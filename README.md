Before start
---------------
* Do mass change-replace " **theme_text_domain** " to your new theme text domain;
* Run ```npm run i``` in your command line;
* Don't forget to change data in **style.css**
* In **webpack.mix.js** set **proxy** const to your virtial domain address;
* Don't forget start your web server before ```npm run watch```

What's included?
---------------
* **Laravel Mix** for building assets & browsersync for live realod
* **Bootstrap** (grid)
* **SweetAlert 2 (CDN)** - modal\alert windows;
* **WebFont.js (CDN)** - loading google fonts;
* **RFS (Responsive Font size)** - auto scaling font-size for responsiveness;

A few advices
---------------
* For page templates use template-*.php page templates naming
* Assets has two sub folders
  - build - all compiled sass/js/images/fonts goes here
  - theme - use it for your source files
    - sass/settings folder will help you to setup params for your project
* **SASS** - try to divide your blocks into components

Commands
---------------
```npm run watch``` - start virtual server with browsersync proxy & live reload

```npm run production``` - build assets 




[Wordpress Templates Hierarchy](https://developer.wordpress.org/files/2014/10/Screenshot-2019-01-23-00.20.04.png)
---------------
![Wordpress Templates Hierarchy](https://developer.wordpress.org/files/2014/10/Screenshot-2019-01-23-00.20.04.png)