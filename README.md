YamlConfigServiceProvider
=========================

Service provider for Silex for using YAML configuration files.

[![Latest Stable Version](https://poser.pugx.org/deralex/yaml-config-service-provider/v/stable.png)](https://packagist.org/packages/deralex/yaml-config-service-provider)
[![Total Downloads](https://poser.pugx.org/deralex/yaml-config-service-provider/downloads.png)](https://packagist.org/packages/deralex/yaml-config-service-provider)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/755e831d-9f81-4caf-9e2d-1e099b55f2fc/mini.png)](https://insight.sensiolabs.com/projects/755e831d-9f81-4caf-9e2d-1e099b55f2fc)

Installation
--------------

To use it add following line to your composer.json:

    "require": {
        ...
        "deralex/yaml-config-service-provider": "1.0.x-dev"
        ...
    }


Usage
--------------
Include following line of code somewhere in your initial Silex file (index.php or whatever):

    $app->register(new DerAlex\Silex\YamlConfigServiceProvider(PATH_TO_CONFIG [, ARRAY_OF_REPLACEMENTS ]));

Now you have access to all of your configuration variables through `$app['config']`.


Examples
---------------

### Basic example

config.yml:

    database:
        host: %mypath%/localhost
        user: myuser
        password: mypassword

index.php:

    <?php
        require_once __DIR__.'/../vendor/autoload.php';

        $app = new Silex\Application();

        // Considering the config.yml files is in the same directory as index.php
        $app->register(new DerAlex\Silex\YamlConfigServiceProvider('config.yml'));

        echo $app['config']['database']['host'];
        ...


### Import example

You can import other config files into one file, for example if you had `parameters.yml`, `security.yml`, you could import these with one call to `config.yml`

config.yml:
    imports:
        - { resource: parameters.yml }
        - { resource: security.yml }

### Replacement variable example

You can pass a array of variables to be replaced as the second parameter:

parameters.yml:

    twig.path:
        - %basepath%/app/views,
        - %basepath%/vendor/example/views

index.php:

    ...
    $app->register(new DerAlex\Silex\YamlConfigServiceProvider('config.yml', [
        'basepath' => realpath(__DIR__.'/../..')
    ]));
    ...


License
----------------
Copyright (c) 2013 Alexander Kluth <contact@alexanderkluth.com>            
                                                                           
Permission is hereby granted,  free of charge,  to any  person obtaining a 
copy of this software and associated documentation files (the "Software"), 
to deal in the Software without restriction,  including without limitation 
the rights to use,  copy, modify, merge, publish,  distribute, sublicense, 
and/or sell copies  of the  Software,  and to permit  persons to whom  the 
Software is furnished to do so, subject to the following conditions:       
                                                                           
The above copyright notice and this permission notice shall be included in 
all copies or substantial portions of the Software.                        
                                                                           
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING  BUT NOT  LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR  PURPOSE AND  NONINFRINGEMENT.  IN NO EVENT SHALL 
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
LIABILITY,  WHETHER IN AN ACTION OF CONTRACT,  TORT OR OTHERWISE,  ARISING 
FROM,  OUT OF  OR IN CONNECTION  WITH THE  SOFTWARE  OR THE  USE OR  OTHER 
DEALINGS IN THE SOFTWARE.                                                  
