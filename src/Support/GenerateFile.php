<?php
namespace Novatura\Laravel\Support;

use Illuminate\Filesystem\Filesystem;

class GenerateFile{
        
    protected $path;
    
    protected $contents;
    
    protected $filesystem;
    
    /**
     * __construct
     *
     * @param  mixed $path
     * @param  mixed $contents
     * @return void
     */
    public function __construct($path, $contents)
    {
        $this->path = $path;
        $this->contents = $contents;
        $this->filesystem = new Filesystem();
    }

        
    /**
     * generate the file
     * generate
     *
     * @return void
     */
    public function generate()
    {
        $path = $this->path;
        if (!$this->filesystem->exists($path)) {
            return $this->filesystem->put($path, $this->contents);
        }
        throw new \Exception('File already exists!');
    }

}