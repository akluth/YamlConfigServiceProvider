<?php
/******************************************************************************
 * Copyright (c) 2013 Alexander Kluth <contact@alexanderkluth.com>            *
 *                                                                            *
 * Permission is hereby granted,  free of charge,  to any  person obtaining a *
 * copy of this software and associated documentation files (the "Software"), *
 * to deal in the Software without restriction,  including without limitation *
 * the rights to use,  copy, modify, merge, publish,  distribute, sublicense, *
 * and/or sell copies  of the  Software,  and to permit  persons to whom  the *
 * Software is furnished to do so, subject to the following conditions:       *
 *                                                                            *
 * The above copyright notice and this permission notice shall be included in *
 * all copies or substantial portions of the Software.                        *
 *                                                                            *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR *
 * IMPLIED, INCLUDING  BUT NOT  LIMITED TO THE WARRANTIES OF MERCHANTABILITY, *
 * FITNESS FOR A PARTICULAR  PURPOSE AND  NONINFRINGEMENT.  IN NO EVENT SHALL *
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER *
 * LIABILITY,  WHETHER IN AN ACTION OF CONTRACT,  TORT OR OTHERWISE,  ARISING *
 * FROM,  OUT OF  OR IN CONNECTION  WITH THE  SOFTWARE  OR THE  USE OR  OTHER *
 * DEALINGS IN THE SOFTWARE.                                                  *
 ******************************************************************************/
namespace DerAlex\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;


class YamlConfigServiceProvider implements ServiceProviderInterface
{
    protected $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function register(Container $pimple) {
        $config = Yaml::parse(file_get_contents($this->file));

        if (is_array($config)) {
            $this->importSearch($config, $pimple);

            if (isset($pimple['config']) && is_array($pimple['config'])) {
                $pimple['config'] = array_replace_recursive($pimple['config'], $config);
            } else {
                $pimple['config'] = $config;
            }
        } else {
            // Consider YAML file malformed
            $pimple['config'] = array();
        }

    }

    /**
     * Looks for import directives..
     *
     * @param array $config
     *   The result of Yaml::parse().
     */
    public function importSearch(&$config, $pimple) {
        foreach ($config as $key => $value) {
            if ($key == 'imports') {
                foreach ($value as $resource) {
                    $base_dir = str_replace(basename($this->file), '', $this->file);
                    $new_config = new YamlConfigServiceProvider($base_dir . $resource['resource']);
                    $new_config->register($pimple);
                }
                unset($config['imports']);
            }
        }
    }

    public function getConfigFile() {
        return $this->file;
    }
}

