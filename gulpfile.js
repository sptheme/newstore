// Defining base pathes
var basePaths = {
    bower: './bower_components/',
    node: './node_modules/',
    dev: './src/'
};

// browser-sync watched files
// automatically reloads the page when files changed
var browserSyncWatchFiles = [
    './css/*.min.css',
    './js/*.min.js',
    './*.php'
];
// browser-sync options
// see: https://www.browsersync.io/docs/options/
var browserSyncOptions = {
    proxy: "localhost/poshedition/",
    notify: false
};

// Defining requirements
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var merge2 = require('merge2');
var ignore = require('gulp-ignore');
var rimraf = require('gulp-rimraf');
var clone = require('gulp-clone');
var merge = require('gulp-merge');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;


// Run: 
// gulp sass + cssnano + rename
// Prepare the min.css for production (with 2 pipes to be sure that "child-theme.css" == "child-theme.min.css")
gulp.task('scss-for-prod', function() {
    var source =  gulp.src('./sass/*.scss')
        .pipe(plumber())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass());

    var pipe1 = source.pipe(clone())
        .pipe(sourcemaps.write(undefined, { sourceRoot: null }))
        .pipe(gulp.dest('./css'));

    var pipe2 = source.pipe(clone())
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'})) 
        .pipe(gulp.dest('./css'));

    return merge(pipe1, pipe2);
});


// Run: 
// gulp sourcemaps + sass + reload(browserSync)
// Prepare the child-theme.css for the developpment environment
gulp.task('scss-for-dev', function() {
    gulp.src('./sass/*.scss')
        .pipe(plumber())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass())
        .pipe(sourcemaps.write(undefined, { sourceRoot: null }))
        .pipe(gulp.dest('./css'))
        .pipe(reload({stream: true}));
});

gulp.task('watch-scss', ['browser-sync'], function () {
    gulp.watch('./sass/**/*.scss', ['scss-for-dev']);
});


// Run: 
// gulp sass
// Compiles SCSS files in CSS
gulp.task('sass', function () {
    gulp.src('./sass/*.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(gulp.dest('./css'));
});

// Run: 
// gulp watch
// Starts watcher. Watcher runs gulp sass task on changes
gulp.task('watch', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
    gulp.watch('./css/theme.css', ['cssnano']);
});

// Run: 
// gulp nanocss
// Minifies CSS files
gulp.task('cssnano', ['cleancss'], function(){
  return gulp.src('./css/*.css')
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(plumber())
    .pipe(rename({suffix: '.min'}))
    .pipe(cssnano({discardComments: {removeAll: true}}))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./css/'))
    .pipe(reload({stream: true}));
}); 

gulp.task('cleancss', function() {
  return gulp.src('./css/*.min.css', { read: false }) // much faster 
    .pipe(ignore('theme.css'))
    .pipe(rimraf());
});

// Run: 
// gulp browser-sync
// Starts browser-sync task for starting the server.
gulp.task('browser-sync', function() {
    browserSync.init(browserSyncWatchFiles, browserSyncOptions);
});

// Run: 
// gulp watch-bs
// Starts watcher with browser-sync. Browser-sync reloads page automatically on your browser
gulp.task('watch-bs', ['browser-sync', 'watch', 'cssnano'], function () { });

// Run: 
// gulp scripts. 
// Uglifies and concat all JS files into one
gulp.task('scripts', function() {
  gulp.src([
    basePaths.dev + 'js/superfish/hoverIntent.js',
    basePaths.dev + 'js/superfish/superfish.min.js',
    basePaths.dev + 'js/superfish/supersubs.js',
    basePaths.dev + 'js/imagesloaded/imagesloaded.pkgd.min.js',
    basePaths.dev + 'js/isotope/isotope.pkgd.min.js',    
    basePaths.dev + 'js/sidr/jquery.sidr.min.js',
    basePaths.dev + 'js/leanner-modal.js',
    basePaths.dev + 'js/owl-carousel2/owl.carousel.min.js', 
    basePaths.dev + 'js/owl-carousel2/owl.carousel2.thumbs.min.js',
    basePaths.dev + 'js/magnific-popup/jquery.magnific-popup.min.js',// Must be loaded before BS4    
    basePaths.dev + 'js/tether.js', // Must be loaded before BS4

    // Start - All BS4 stuff
    basePaths.dev + 'js/bootstrap4/bootstrap.js', 

    // End - All BS4 stuff

    basePaths.dev + 'js/skip-link-focus-fix.js'
    ])
    .pipe(concat('theme.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./js/'));

  gulp.src([
    basePaths.dev + 'js/superfish/hoverIntent.js',
    basePaths.dev + 'js/superfish/superfish.js',
    basePaths.dev + 'js/superfish/supersubs.js',
    basePaths.dev + 'js/imagesloaded/imagesloaded.js',
    basePaths.dev + 'js/isotope/isotope.pkgd.js',
    basePaths.dev + 'js/sidr/jquery.sidr.js',
    basePaths.dev + 'js/leanner-modal.js',
    basePaths.dev + 'js/owl-carousel2/owl.carousel.js', 
    basePaths.dev + 'js/owl-carousel2/owl.carousel2.thumbs.js',
    basePaths.dev + 'js/magnific-popup/jquery.magnific-popup.js',// Must be loaded before BS4
    basePaths.dev + 'js/tether.js', // Must be loaded before BS4

    // Start - All BS4 stuff
    basePaths.dev + 'js/bootstrap4/bootstrap.js', 

    // End - All BS4 stuff

    basePaths.dev + 'js/skip-link-focus-fix.js'
    ])
    .pipe(concat('theme.js'))
    .pipe(gulp.dest('./js/'));
});

// Run: 
// gulp copy-assets. 
// Copy all needed dependency assets files from bower_component assets to themes /js, /scss and /fonts folder. Run this task after bower install or bower update


////////////////// All Bootstrap SASS  Assets /////////////////////////
gulp.task('copy-assets', function() {


////////////////// All Bootstrap 4 Assets /////////////////////////
// Copy all Bootstrap JS files 
    gulp.src(basePaths.node + 'bootstrap/dist/js/**/*.js')
       .pipe(gulp.dest(basePaths.dev + '/js/bootstrap4'));

// Copy all Bootstrap SCSS files
    gulp.src(basePaths.node + 'bootstrap/scss/**/*.scss')
       .pipe(gulp.dest(basePaths.dev + '/sass/bootstrap4'));
////////////////// End Bootstrap 4 Assets /////////////////////////

// Copy all Font Awesome Fonts
    gulp.src(basePaths.node + 'fontawesome/fonts/**/*.{ttf,woff,woff2,eof,svg}')
        .pipe(gulp.dest('./fonts'));

// Copy all Font Awesome SCSS files
    gulp.src(basePaths.node + 'fontawesome/scss/*.scss')
        .pipe(gulp.dest(basePaths.dev + '/sass/fontawesome'));

// owl JS files
    gulp.src(basePaths.node + 'owl.carousel/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js/owl-carousel2'));

// Copy all Owl2 SCSS files
    gulp.src(basePaths.node + 'owl.carousel/src/scss/*.scss')
       .pipe(gulp.dest(basePaths.dev + '/sass/owl-carousel2'));

// Copy all Owl2 CSS files
    gulp.src(basePaths.node + 'owl.carousel/dist/assets/*.css')
        .pipe(gulp.dest(basePaths.dev + '/css/owl-carousel2'));

// owl thumbs JS files
    gulp.src(basePaths.node + 'owl.carousel2.thumbs/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js/owl-carousel2'));        

// Copy jQuery
    gulp.src(basePaths.node + 'jquery/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js'));

// Copy Tether JS files
    gulp.src(basePaths.node + 'tether/dist/js/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js'));

// Copy Tether CSS files
    gulp.src(basePaths.node + 'tether/dist/css/*.css')
        .pipe(gulp.dest(basePaths.dev + '/css/tether'));

// Copy Superfish JS files
    gulp.src(basePaths.node + 'superfish/dist/js/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js/superfish'));

// Copy all Superfish CSS files
    gulp.src(basePaths.node + 'superfish/dist/css/*.css')
        .pipe(gulp.dest(basePaths.dev + '/css/superfish'));

// Copy ImagesLoaded JS files
    gulp.src(basePaths.node + 'imagesloaded/*.js')
        .pipe(ignore('gulpfile.js'))
        .pipe(gulp.dest(basePaths.dev + '/js/imagesloaded'));

// Copy Isotope JS files
    gulp.src(basePaths.node + 'isotope-layout/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js/isotope'));        

// Copy Sidr JS files
    gulp.src(basePaths.node + 'sidr/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js/sidr/'));

// Copy Sidr SCSS files
    gulp.src(basePaths.node + 'sidr/src/scss/**/*.scss')
        .pipe(gulp.dest(basePaths.dev + '/sass/sidr'));

// Copy Sidr CSS files
    gulp.src(basePaths.node + 'sidr/dist/stylesheets/*.css')
        .pipe(gulp.dest(basePaths.dev + '/css/sidr'));

// Copy Magnific Popup JS files
    gulp.src(basePaths.node + 'magnific-popup/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js/magnific-popup/'));

// Copy Magnific Popup SCSS files
    gulp.src(basePaths.node + 'magnific-popup/src/css/**/*.scss')
        .pipe(gulp.dest(basePaths.dev + '/sass/magnific-popup'));

// Copy Magnific Popup CSS files
    gulp.src(basePaths.node + 'magnific-popup/dist/*.css')
        .pipe(gulp.dest(basePaths.dev + '/css/magnific-popup'));                      

});


// Run // gulp dist // Copies the files to the dist folder for distributon 
gulp.task('dist', function() { 
    gulp.src(['!sass','!bower_components', '!node_modules','!src','!dist','!bower.json', '!gulpfile.js', '!package.json', '*']) 
    .pipe(gulp.dest('dist/')) 
});