<?php

/**
 * Loads a file as a template.
 * @param string $path Filepath.
 * @return string Contents of the file.
 */
function loadTemplate($path) {
    return file_get_contents($path);
}
