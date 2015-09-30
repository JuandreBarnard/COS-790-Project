<?php

require_once __DIR__ . '/ThemeConfig.class.php';

/**
 * A theme object that handles all theme related information.
 */
class Theme {

    /**
     * @var ThemeConfig configuration/settings.
     */
    protected $themeConfig = NULL;

    /**
     * Theme constructor.
     * @param ThemeConfig $themeConfig Theme configuration.
     */
    public function __construct(ThemeConfig $themeConfig) {
        $this->themeConfig = $themeConfig;
    }

    /**
     * Path getter.
     * @return int Theme connection path.
     */
    public function getPath() {
        return $this->themeConfig->getPath();
    }

    /**
     * Theme connection path setter.
     * @param int $path Theme absolute path.
     */
    public function setPath($path) {
        $this->path = $this->themeConfig->setPath($path);
    }

}
