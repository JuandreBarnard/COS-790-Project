<?php

/**
 * Theme configuration instance.
 */
class ThemeConfig {

    /**
     * @var string Theme user. 
     */
    private $path = NULL;

    /**
     * ThemeConfig constructor.
     * @param int $path Absolute path to theme.
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * Path getter.
     * @return int Theme connection path.
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Theme connection path setter.
     * @param int $path Theme absolute path.
     */
    public function setPath($path) {
        $this->path = $path;
    }

}
