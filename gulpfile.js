'use strict';

/**
 * Load Plugins.
 *
 * Load gulp plugins and assing them semantic names.
 */
 var $                    = require('gulp-load-plugins')();
 var gutil                = require('gulp-util');
 var yaml                 = require('js-yaml');
 var fs                   = require('fs');
 var yargs                = require('yargs');
var gulp                 = require('gulp'); // Gulp of-course
var gulpif               = require('gulp-if');
var webpack              = require('webpack');
var webpackStream        = require('webpack-stream');
var webpackConfig        = require('./webpack.config.js');
var runSequence          = require('run-sequence');
var plumber              = require('gulp-plumber');
var merge                = require('merge-stream');


// CSS related plugins.
var sass         = require('gulp-sass'); // Gulp pluign for Sass compilation.
var minifycss    = require('gulp-uglifycss'); // Minifies CSS files.
var autoprefixer = require('gulp-autoprefixer'); // Autoprefixing magic.
// var mmq          = require('gulp-merge-media-queries'); // Combine matching media queries into one media query definition.

// JS
var uglify       = require('gulp-uglify'); //Minifies JS files

// Image realted plugins.
var imagemin     = require('gulp-imagemin'); // Minify PNG, JPEG, GIF and SVG images with imagemin.
// var iconfontCSS  = require('gulp-iconfont-css'); // Minify PNG, JPEG, GIF and SVG images with imagemin.
// var iconfont     = require('gulp-iconfont'); // Minify PNG, JPEG, GIF and SVG images with imagemin.

// Utility related plugins.
var rename       = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css
// var lineec       = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
// var filter       = require('gulp-filter'); // Enables you to work on a subset of the original files by filtering them using globbing.
var sourcemaps   = require('gulp-sourcemaps'); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css)
var notify       = require('gulp-notify'); // Sends message notification to you
// var browserSync  = require('browser-sync').create(); // Reloads browser and injects CSS. Time-saving synchronised browser testing.
// var reload       = browserSync.reload; // For manual browser reload.
// var wpPot        = require('gulp-wp-pot'); // For generating the .pot file.
// var sort         = require('gulp-sort'); // Recommended to prevent unnecessary changes in pot-file.

// Check for --production flag
const PRODUCTION = !!(yargs.argv.production);

// Check for --development flag unminified with sourcemaps
const DEV = !!(yargs.argv.dev);

// Load settings from settings.yml
const { COMPATIBILITY, PATHS, PROJECT } = loadConfig();

// Check if file exists synchronously
function checkFileExists(filepath) {
  var flag = true;
  try {
    fs.accessSync(filepath, fs.F_OK);
  } catch(e) {
    flag = false;
  }
  return flag;
}



// Load default or custom YML config file
function loadConfig() {
  gutil.log('Loading config file...');

  if (checkFileExists('config.yml')) {
    // config.yml exists, load it
    gutil.log(gutil.colors.cyan('config.yml'), 'exists, loading', gutil.colors.cyan('config.yml'));
    var ymlFile = fs.readFileSync('config.yml', 'utf8');
    return yaml.load(ymlFile);

  } else if(checkFileExists('config-default.yml')) {
    // config-default.yml exists, load it
    gutil.log(gutil.colors.cyan('config.yml'), 'does not exist, loading', gutil.colors.cyan('config-default.yml'));
    var ymlFile = fs.readFileSync('config-default.yml', 'utf8');
    return yaml.load(ymlFile);

  } else {
    // Exit if config.yml & config-default.yml do not exist
    gutil.log('Exiting process, no config file exists.');
    gutil.log('Error Code:', err.code);
    process.exit(1);
  }
}



/**
 * Task: Webpack.
 *
 */
 gulp.task('webpack', function(done) {
   var wp_voting = gulp.src('src/js/wp_voting.js')
   .pipe(plumber({ errorHandler: function(err) {
    notify.onError({
      title: "Gulp error in " + err.plugin,
      message:  err.toString()
    })(err);

            // play a sound once
            gutil.beep();
          }}))
   .pipe(webpackStream(webpackConfig), webpack)
   .pipe(gulpif(PRODUCTION, $.uglify()))
   .pipe(gulp.dest('assets/js/'));

   var wp_voting_frontend = gulp.src('src/js/wp_voting_frontend.js')
   .pipe(plumber({ errorHandler: function(err) {
    notify.onError({
      title: "Gulp error in " + err.plugin,
      message:  err.toString()
    })(err);

            // play a sound once
            gutil.beep();
          }}))
   .pipe(webpackStream(webpackConfig), webpack)
   .pipe(gulpif(PRODUCTION, $.uglify()))
   .pipe(gulp.dest('assets/js/'));

    var wp_voting_yt_api = gulp.src('src/js/wp_voting_yt_api.js')
   .pipe(plumber({ errorHandler: function(err) {
    notify.onError({
      title: "Gulp error in " + err.plugin,
      message:  err.toString()
    })(err);

            // play a sound once
            gutil.beep();
          }}))
   .pipe(gulpif(PRODUCTION, $.uglify()))
    .pipe(rename(function(path){
      path.basename += '.min'
    }))
   .pipe(gulp.dest('assets/js/'));


   var wp_voting_tinymce_btn = gulp.src('src/js/wp_voting_tinymce_btn.js')
   .pipe(plumber({ errorHandler: function(err) {
    notify.onError({
      title: "Gulp error in " + err.plugin,
      message:  err.toString()
    })(err);

            // play a sound once
            gutil.beep();
          }}))
   .pipe(webpackStream(webpackConfig), webpack)
   .pipe(gulpif(PRODUCTION, $.uglify()))
   .pipe(gulp.dest('assets/js/'));


   var wp_voting_vote = gulp.src('src/js/wp_voting_vote.js')
   .pipe(plumber({ errorHandler: function(err) {
    notify.onError({
      title: "Gulp error in " + err.plugin,
      message:  err.toString()
    })(err);

            // play a sound once
            gutil.beep();
          }}))
   .pipe(webpackStream(webpackConfig), webpack)
   .pipe(gulpif(PRODUCTION, $.uglify()))
   .pipe(gulp.dest('assets/js/'));

   return merge(wp_voting, wp_voting_frontend, wp_voting_yt_api, wp_voting_tinymce_btn, wp_voting_vote);
 });




/**
 * Task: `styles`.
 *
 */
 gulp.task('styles', function () {

   var wp_voting = gulp.src( 'src/css/wp_voting.css' )
   .pipe(plumber({ errorHandler: function(err) {
    notify.onError({
      title: "Gulp error in " + err.plugin,
      message:  err.toString()
    })(err);

              // play a sound once
              gutil.beep();
            }}))
   .pipe( autoprefixer( COMPATIBILITY ) )
    .pipe(gulpif(PRODUCTION, minifycss())) //minifie uniquement en environnment de prod
    .pipe(rename(function(path){
      path.basename += '.min'
    }))
    .pipe( gulp.dest( 'assets/css' ) )
    .pipe( notify( { message: 'TASK: "style wp_voting" Completed!', onLast: true } ) );


    var wp_voting_frontend = gulp.src( 'src/css/wp_voting_frontend.css' )
    .pipe(plumber({ errorHandler: function(err) {
      notify.onError({
        title: "Gulp error in " + err.plugin,
        message:  err.toString()
      })(err);

              // play a sound once
              gutil.beep();
            }}))
    .pipe( autoprefixer( COMPATIBILITY ) )
    .pipe(gulpif(PRODUCTION, minifycss())) //minifie uniquement en environnment de prod
    .pipe(rename(function(path){
      path.basename += '.min'
    }))
    .pipe( gulp.dest( 'assets/css' ) )
    .pipe( notify( { message: 'TASK: "style wp_voting_frontend" Completed!', onLast: true } ) );

    return merge(wp_voting, wp_voting_frontend);

  });



 /**
  * Task: `images`.
  *
  * Minifies PNG, JPEG, GIF and SVG images.
  *
  * This task does the following:
  *     1. Gets the source of images raw folder
  *     2. Minifies PNG, JPEG, GIF and SVG images
  *     3. Generates and saves the optimized images
  *
  * This task will run only once, if you want to run it
  * again, do it with the command `gulp images`.
  */
  gulp.task( 'images', function() {
    gulp.src( PATHS.img )
    .pipe(imagemin([
      imagemin.gifsicle({interlaced: true}),
      imagemin.jpegtran({progressive: true}),
      imagemin.optipng({optimizationLevel: 5}),
      imagemin.svgo({
        plugins: [
        {removeViewBox: true},
        {cleanupIDs: false}
        ]
      })
      ])
    )
    .pipe(gulp.dest( 'assets/img/' ))
    .pipe( notify( { message: 'TASK: "images" Completed! 💯', onLast: true } ) );
  });


 // gulp.task('iconfont', function() {
 //     gulp.src(PATHS.iconfont)
 //       .pipe(iconfontCSS({
 //         fontName: PROJECT.name,
 //         path: 'src/scss/templates/_icons.scss',
 //         targetPath: '../../src/scss/_icons.scss',
 //         fontPath: '../fonts/'
 //       }))
 //       .pipe(iconfont({
 //         fontName: PROJECT.name,
 //         // Remove woff2 if you get an ext error on compile
 //        //  formats: ['svg', 'ttf', 'eot', 'woff', 'woff2'],
 //         formats: ['ttf', 'woff', 'woff2'],
 //         normalize: true,
 //         fontHeight: 1001
 //       }))
 //       .pipe(gulp.dest('./src/fonts/'))
 //       .pipe( notify( { message: 'TASK: "Icons" Completed! 💯', onLast: true } )
 //       )
 //   });

 gulp.task('copy-fonts', function(){
   gulp.src('./src/fonts/**')
   .pipe(gulp.dest('./assets/fonts'));
 });

   // gulp.task('icons', function(){
   //    runSequence('iconfont', 'copy-fonts', 'bs-reload');
   // });


 /**
  * WP POT Translation File Generator.
  *
  * * This task does the following:
  *     1. Gets the source of all the PHP files
  *     2. Sort files in stream by path or any custom sort comparator
  *     3. Applies wpPot with the variable set at the config file
  *     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
  */
 // gulp.task( 'translate', function () {
 //     return gulp.src( PATHS.php )
 //         .pipe(sort())
 //         .pipe(wpPot( {
 //             domain        : PROJECT.name,
 //             destFile      : PROJECT.name + '.pot',
 //             package       : PROJECT.name,
 //             bugReport     : 'nextia.fr',
 //             lastTranslator: 'nextia.fr',
 //             team          : 'nextia'
 //         } ))
 //        .pipe(gulp.dest(PATHS.translate))
 //        .pipe( notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) )
 // });


 /**
  * Watch Tasks.
  *
  * Watches for file changes and runs specific tasks.
  */

  gulp.task( 'default', function () {
   gulp.watch('src/js/**/*.js', ['webpack']);
   gulp.watch( PATHS.css, [ 'styles'] );
   //gulp.watch( PATHS.iconfont, [ 'icons' ] ); // Reload on SCSS file changes.
   gulp.watch( PATHS.img, ['images']);
 });


 /**
  * Build tasks
  */

  gulp.task('build', function() {
    //runSequence('styles', 'webpack', 'icons', 'images')
    runSequence('styles', 'webpack', 'images', 'copy-fonts')
  })



// GULP TASK ON WP-VOTING PLUGIN

// gulp.task('styles-plugin', function () {
//     // Gulp Wp-Voting Plug In
//     gulp.src( ['../../plugins/wp-voting-contest/assets/css/src/*.css'] )
//     .pipe(plumber({ errorHandler: function(err) {
//       notify.onError({
//         title: "Gulp error in " + err.plugin,
//         message:  err.toString()
//       })(err);

//               // play a sound once
//               gutil.beep();
//             }}))
//     .pipe( sourcemaps.init() )
    // .pipe( sass( {
    //   includePaths: ['node_modules/foundation-sites/scss','node_modules/owl.carousel/src/scss'],
    //   errLogToConsole: true,
    // //  outputStyle: 'compact'
    //   outputStyle: 'compressed',
    //   // outputStyle: 'nested',
    //   outputStyle: 'expanded',
    // } ) )
  //   .pipe( autoprefixer( COMPATIBILITY ) )
  //   .pipe(gulpif(!PRODUCTION, $.sourcemaps.write())) //ecrit le sourcemap uniquement en environnement dev
  //   .pipe(gulpif(PRODUCTION, minifycss())) //ecrit le sourcemap uniquement en environnement dev
  //   .pipe(rename(function(path){
  //     path.basename += '.min'
  //   }))
  //   .pipe( gulp.dest( '../../plugins/wp-voting-contest/assets/css' ) )
  //   .pipe( notify( { message: 'TASK: "styles-plugin" Completed!', onLast: true } ) )
  // });


// gulp.task('webpack-plugin', function(done) {
//   return gulp.src('../../plugins/wp-voting-contest/assets/js/src/*.js')
//   .pipe(plumber({ errorHandler: function(err) {
//     notify.onError({
//       title: "Gulp error in " + err.plugin,
//       message:  err.toString()
//     })(err);

//             // play a sound once
//             gutil.beep();
//           }}))

//   .pipe(webpackStream({
//    module: {
//     rules: [
//     {
//       test: /\.js$/,
//       use: {
//         loader: 'babel-loader',
//         options: {
//           presets: ['../../../../../themes/nextiawp/node_modules/babel-preset-es2015']
//         }
//       }
//     }
//     ]
//   },
//   entry: {
//     wp_voting_frontend: ['../../plugins/wp-voting-contest/assets/js/src/wp_voting_frontend.js'],
//     wp_voting_vote: ['../../plugins/wp-voting-contest/assets/js/src/wp_voting_vote.js'],
//     wp_voting: ['../../plugins/wp-voting-contest/assets/js/src/wp_voting.js'],
//     wp_voting_vote_tinymce_btn: ['../../plugins/wp-voting-contest/assets/js/src/wp_voting_tinymce_btn.js'],
//   },
//   output: {
//     path: __dirname+'../../plugins/wp-voting-contest/assets/js/',
//     filename: '[name].min.js',
//   },
//   externals: {
//     jquery: 'jQuery'
//   }
// }))
//   .pipe(gulpif(PRODUCTION, $.uglify()))
//   .pipe(gulp.dest('../../plugins/wp-voting-contest/assets/js/'))
//   ;});

