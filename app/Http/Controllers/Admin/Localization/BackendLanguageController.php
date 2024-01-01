<?php

namespace App\Http\Controllers\Admin\Localization;

use App\Http\Controllers\Controller;
use App\Models\Admin\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class BackendLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::where('delete', 0)->get();
        return view('backend.blade.language.backend_language', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data) : RedirectResponse
    {
        $directories = explode(',', $data->directory);
        $language_code = $data->lang;
        $fileName = $data->file_name;
        $localizationStrings = [];

        foreach ($directories as $directory) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            //iterate over each file of the directory
            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }
                // $localizationStrings[]=$file->getPathname();
                $contents = file_get_contents($file->getPathname());

                preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $match = preg_replace('/^(frontend|admin_local)\./','',$match);
                        if (!in_array($match, $localizationStrings)) {
                            $localizationStrings[$match] = $match;
                        }
                    }
                }
            }
        }
        $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";

        //create language folder if it is not exist
        if (!File::isDirectory(lang_path($language_code))) {
            File::makeDirectory(lang_path($language_code), 0755, true);
        }

        file_put_contents(lang_path($language_code . '/' . $fileName . '.php'), $phpArray);


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $code) : Response
    {
        $languageStrings = trans($data->file_name, [], $code);
        $languageStrings[$data->string] = $data->translation;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";
        file_put_contents(lang_path($code . '/' . $data->file_name . '.php'), $phpArray);

        return response([
            'value' => $languageStrings[$data->string],
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Localization data update successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function storeTranslateString(Request $data) : RedirectResponse {
        $languageCode = $data->lang;
        $languageStrings = trans($data->file_name, [], $data->lang);
        $keyString = array_keys($languageStrings);
        $keyText = implode(' || ', $keyString);
        $response  = Http::withHeaders([
            'X-RapidAPI-Host' => 'microsoft-translator-text.p.rapidapi.com',
            'X-RapidAPI-Key' => 'fdd77a90f3msh8a9f787264252d4p1cb68ejsn41d6ad25230e',
            'content-type' => 'application/json',
        ])->post('https://microsoft-translator-text.p.rapidapi.com/translate?to%5B0%5D=' . $languageCode . '&api-version=3.0&profanityAction=NoAction&textType=plain', [
            [
                "Text" => $keyText
            ]
        ]);
        $translatedText = json_decode($response->body())[0]->translations[0]->text;
        $translatedString = explode(' || ', $translatedText);
        $updatedArray = array_combine($keyString, $translatedString);

        $phpArray = "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n";
        file_put_contents(lang_path($data->lang . '/' . $data->file_name . '.php'), $phpArray);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
