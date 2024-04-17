### Vision

Visualize your world

## What is vision
Vision is a Laravel web application that utilizes an ONNX model to classify images. This application allows you to upload an image, then uses a pre-trained deep learning model to identify and classify objects present in that image.

## Installation
Before getting started, make sure you have [PHP](https://www.php.net/downloads.php), [Composer](https://getcomposer.org/) and [Node.js](https://nodejs.org/en/download) installed on your machine.

# Get the repo

If all this stuff is installed, you can clone this repository to your local machine:
```
git clone https://github.com/Emil766321/Vision
```

# Configure PHP correctly

This app use a lot of memory, and need php modules to work properly. First, you need to locate the `php.ini` file. You can locate this file with the following command:
```
php --ini
```

Then, open the file and search for the `memory_limit` line. Then change the value by 1024:
```
memory_limit=1024M
```

Then, you need to enable ffi in php. To do that, you can just add a line in the `php.ini` file:
```
ffi.enable=true
```

And then, make sur you have gd installed in php. If you have not php gd, you can install it. 

On Linux:
```
sudo apt-get install php-gd
```

On Mac with brew:
```
brew install php-gd
```

>Please note, for Mac & Linux, it may not work with only run the command line. If it's not working, just follow the same step as a Windows user

On Windows:
On windows, you need to locate on the `php.ini` file the line `;extension=gd` and remove the `;`. If you have not this line, you can jus add this line on the file:
```
extension=gd
```

>Please note that GD can already been installed on the default version of php, so I recomand to run the app first, and if there is an error, try to install GD

# Configure Laravel

For this, you need to be in the `vision` folder. You can navigate trough it with the following command:
```
cd vision
```

Install PHP dependencies via Composer:
```
composer install
````

Install JavaScript dependencies via npm:
```
npm install
```

Create a .env file by duplicating the .env.example file. You can do this with the following command:
```
cp .env.example .env
```

When you have this .env file, you have to fill it with the rights informations, like your db address, username and password. But let the key application empty. You have to generate it when the .env file is already filled. Generate the key with the command:
```
php artisan key:generate
````

Run database migrations:
```
php artisan migrate
````

Start the Laravel development server:
```
php artisan serve
````

Run the npm dev server on another terminal window:
```
npm run dev
````

This two windows need to be open while you access the app. When you want to stop the server, you can just press on Ctrl + C

Visit http://localhost:8000 in your browser to access the Vision application.

## Dependencies

[PHP](https://www.php.net/downloads.php)
[Laravel](https://laravel.com/)
[ONNXRuntime for PHP](https://github.com/ankane/onnxruntime-php)
[Composer](https://getcomposer.org/)
[Node.js](https://nodejs.org/en/download)
