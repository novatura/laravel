<?php

namespace Novatura\Laravel\Support;

class GenerateStub {

    protected $path;

    protected $variables = [];


    /**
     * __construct
     *
     * @param  string $path
     * @param  array $variables
     * @return void
     */
    public function __construct(string $path, array $variables = [])
    {
        $this->path = $path;
        $this->variables = $variables;
    }
    
    public function generate(){
        $contents = file_get_contents($this->path);
    
        foreach ($this->variables as $search => $variable) {
            // Make the search case-insensitive and allow optional spaces around the variable
            $pattern = '/{{\s*' . preg_quote($search, '/') . '\s*}}/i';
            $contents = preg_replace($pattern, $variable, $contents);
        }
    
        return $contents;
    }


}