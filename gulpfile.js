"use strict";

var gulp = require('gulp'),
    // postcss = require('gulp-postcss'),
    cssnano = require('gulp-cssnano'),
    pxtorem = require('gulp-pxtorem'),
    precss = require('precss'),
    autoprefixer = require('gulp-autoprefixer'),
    mqpacker = require('css-mqpacker'),
    sass = require('gulp-sass'),
    sassUnicode = require('gulp-sass-unicode'),  // Не допускает ошибок при наличии обратного слеша "\fff"
    sourcemaps = require('gulp-sourcemaps'),
    rigger = require('gulp-rigger'), // Собирает html файлы
    del = require('del'), // Удаление файлов
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    changed = require('gulp-changed'), // запускают таски только для изменившихся файлов
    duration    = require('gulp-duration'),
    browserSync = require('browser-sync').create();

var path = {
    build: { //Тут мы укажем куда складывать готовые после сборки файлы
        html: 'dist/',
        js: 'dist/js/',
        style: 'templates/kit/css/',
        styleContr:'templates/kit/controllers/',
        img: 'templates/kit/img/',
        fonts: 'templates/kit/fonts/'
    },
    src: { //Пути откуда брать исходники
        html: 'src/*.html', //Синтаксис src/*.html говорит gulp что мы хотим взять все файлы с расширением .html
        js: 'src/js/**/*.js',//В стилях и скриптах нам понадобятся только main файлы
        style: 'templates/kit/src/sass/*.scss',
        styleDefault: 'templates/kit/src/sass/default/*.css',
        styleContr: 'templates/kit/src/sass/theme/controllers/*.scss',
        img: 'templates/kit/src/img/**/*.*', //Синтаксис img/**/*.* означает - взять все файлы всех расширений из папки и из вложенных каталогов
        fonts: 'templates/kit/src/fonts/**/*.*'
    },
    watch: { //Тут мы укажем, за изменением каких файлов мы хотим наблюдать
        html: 'src/**/*.html',
        js: 'src/js/**/*.js',
        style: 'templates/kit/src/sass/**/*.scss',
        img: 'templates/kit/src/img/**/*.*',
        fonts: 'templates/kit/src/fonts/**/*.*'
    },
    browser: {
        html: 'dist/**/*.html',
        php: 'templates/kit/**/*.php',
        js: 'templates/kit/js/**/*.js',
        style: 'templates/kit/css/**/*.css',
        styleContr: 'templates/kit/controllers/**/*.css',
        img: 'templates/kit/img/**/*.*',
        fonts: 'templates/kit/fonts/**/*.*'
    },
    clean: {
        style: 'templates/kit/css/**/*.*',
        styleContr: 'templates/kit/controllers/**/*.+(css|map)',
        fonts: 'templates/kit/fonts/**/*.*',
    }
};

gulp.task('browser-sync', ['style.min:build'], function() {
    browserSync.init({
        proxy: 'kit',
        port: '3010',
        logConnections: true,
    });

    // browserSync.init({
    //     server: {
    //         baseDir: "./dist/"
    //     }
    // });

    gulp.watch(path.browser.js).on("change", browserSync.reload);
    gulp.watch(path.browser.html).on('change', browserSync.reload);
    gulp.watch(path.browser.php).on('change', browserSync.reload);
});

gulp.task('html:build', function () {
    gulp.src(path.src.html) //Выберем файлы по нужному пути
        .pipe(plumber())
        .pipe(rigger()) //Прогоним через rigger
        .pipe(gulp.dest(path.build.html)) //Выплюнем их в папку build
});

gulp.task('js:build', function () {
    gulp.src(path.src.js) //Найдем наш main файл
        .pipe(changed(path.build.js))
        // .pipe(plumber())
        // .pipe(rigger())
        // .pipe(sourcemaps.init()) //Инициализируем sourcemap
        // .pipe(sourcemaps.write('')) //Пропишем карты
        .pipe(gulp.dest(path.build.js)) //Выплюнем готовый файл в build
});

gulp.task('style:build', function () {
    gulp.src(path.src.style) //Выберем наш system.scss
        .pipe(plumber())
        .pipe(sourcemaps.init({largeFile: true})) //То же самое что и с js
        .pipe(sass().on('error', sass.logError)) //Скомпилируем
        .pipe(sassUnicode())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(pxtorem())
        .pipe(sourcemaps.write('../css/maps'))
        .pipe(gulp.dest(path.build.style)) //И в build
});

gulp.task('style.min:build', function () {
    gulp.src(path.src.style) //Выберем наш system.scss
        .pipe(plumber())
        .pipe(sourcemaps.init({largeFile: true})) //То же самое что и с js
        .pipe(sass().on('error', sass.logError)) //Скомпилируем
        .pipe(sassUnicode())
        .pipe(cssnano({zindex: false})) //Сожмем
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(pxtorem())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('../css/maps'))
        .pipe(duration('style.min:build time'))
        .pipe(gulp.dest(path.build.style)) //И в build
        .pipe(browserSync.stream())
});

gulp.task('styleContr:build', function () {
    gulp.src(path.src.styleContr) //Выберем наш system.scss
        .pipe(plumber())
        .pipe(sourcemaps.init({largeFile: true})) //То же самое что и с js
        .pipe(sass().on('error', sass.logError)) //Скомпилируем
        .pipe(sassUnicode())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(pxtorem())
        .pipe(rename(function (path) {
            path.dirname += "/"+path.basename+"";
            path.basename = "styles";
        }))
        .pipe(sourcemaps.write(''))
        .pipe(gulp.dest(path.build.styleContr))
        .pipe(browserSync.stream())
});

gulp.task('styleDefault:build', function () {
    gulp.src(path.src.styleDefault) //Выберем файлы по нужному пути
        .pipe(plumber())
        .pipe(gulp.dest(path.build.style)) //Выплюнем их в папку build
});

gulp.task('img:build', function () {
    var imagemin = require('gulp-imagemin'),
        imageminGifsicle = require('imagemin-gifsicle'),
        imageminJpegtran = require('imagemin-jpegtran'),
        imageminOptipng = require('imagemin-optipng'),
        imageminSvgo = require('imagemin-svgo');

    gulp.src(path.src.img) //Выберем наши картинки
        .pipe(changed(path.build.img))
        .pipe(plumber())
        .pipe(imagemin([
            imageminGifsicle({interlaced: true}),
            imageminJpegtran({progressive: true}),
            imageminOptipng({optimizationLevel: 5}),
            imageminSvgo({plugins: [{removeViewBox: true}]})
        ]))
        .pipe(gulp.dest(path.build.img)) //И бросим в build
});

gulp.task('fonts:build', function () {
    gulp.src(path.src.fonts) //Выберем файлы по нужному пути
        .pipe(gulp.dest(path.build.fonts)) //Выплюнем их в папку build
});

gulp.task('build', [
    'html:build',
    'js:build',
    'style:build',
    'style.min:build',
    'styleContr:build',
    'styleDefault:build',
    'fonts:build',
    'img:build'
]);

gulp.task('watch', function () {
    gulp.watch(path.watch.html, ['html:build']);
    gulp.watch(path.watch.style, ['style:build']);
    gulp.watch(path.watch.style, ['style.min:build']);
    gulp.watch(path.watch.style, ['styleContr:build']);
    gulp.watch(path.watch.js, ['js:build']);
    gulp.watch(path.watch.img, ['img:build']);
    gulp.watch(path.watch.fonts, ['fonts:build']);
});

/** FTP Configuration **/
var ftp = require('vinyl-ftp'),
    gutil = require('gulp-util');

var user = '',
    password = '',
    host = '',
    port = 21,
    localFilesGlob = [
        'dist/**/*.html',
        'dist/js/**/*.js',
        'dist/css/**/*.css',
        'dist/img/**/*.*',
        'dist/fonts/**/*.*'
    ], remoteFolder = '/';

// helper function to build an FTP connection based on our configuration
function getFtpConnection() {
    return ftp.create({
        host: host,
        port: port,
        user: user,
        password: password,
        parallel: 5,
        log: gutil.log
    });
}

/**
 * Deploy task.
 * Copies the new files to the server
 */
gulp.task('ftp-deploy', function () {
    var conn = getFtpConnection();

    return gulp.src(localFilesGlob, {base: '.', buffer: false})
        .pipe(conn.newer(remoteFolder)) // only upload newer files
        .pipe(conn.dest(remoteFolder));
});

gulp.task('ftp-deploy-watch', function () {

    var conn = getFtpConnection();

    gulp.watch(localFilesGlob)
        .on('change', function (event) {
            console.log('Changes detected! Uploading file "' + event.path + '", ' + event.type);

            return gulp.src([event.path], {base: '.', buffer: false})
                .pipe(conn.newer(remoteFolder)) // only upload newer files
                .pipe(conn.dest(remoteFolder));
        });
});

gulp.task('ftp', ['build', 'ftp-deploy', 'ftp-deploy-watch', 'watch']);
/* FTP End **/

/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

// Add widget
// app_add - системное имя виджета
// controller: false если виджет общий

var wd_add = "wd.base",
    controller = true;
    if  (controller) {
        var wd_path = "/controllers/kitdeveloper";
    }
    else {
        var wd_path = "";
    }

gulp.task('wdAdd', function () {
    gulp.src("appkit/"+wd_add+"/pascages/system/languages/ru/controllers/kitdeveloper/widgets/wd.name.php")
        .pipe(rename({basename: ''+ wd_add +''}))
        .pipe(debug({title:''+wd_add+':'}))
        .pipe(gulp.dest("./dg/system/languages/ru"+wd_path+"/widgets/"))
    gulp.src("appkit/"+wd_add+"/pascages/system/controllers/kitdeveloper/widgets/wd.base/*.*")
        .pipe(debug({title:''+wd_add+':'}))
        .pipe(gulp.dest("./dg/system"+wd_path+"/widgets/"+wd_add+"/"))
    gulp.src("appkit/"+wd_add+"/pascages/templates/kit/controllers/kitdeveloper/widgets/wd.base/*.*")
        .pipe(debug({title:''+wd_add+':'}))
        .pipe(gulp.dest("./dg/templates/kit/"+wd_path+"/widgets/"+wd_add+"/"))
});

var wd_name = [
        "kitowlcarousel",
        "stretchynav",
    ],
    wd_dir = "app/install/";


gulp.task('wdInstall', function () {

    var debug = require('gulp-debug');

    for (var i = 0; i < wd_name.length; i++) {
        gulp.src([
            'system/**/' + wd_name[i] + '/*.*',
        ])
            .pipe(debug({title: '' + wd_name[i] + ':'}))
            .pipe(gulp.dest('' + wd_dir + wd_name[i] + '/pascages/system/'))

        gulp.src([
            'system/languages/**/' + wd_name[i] + '.*',
        ])
            .pipe(debug({title: '' + wd_name[i] + ':'}))
            .pipe(gulp.dest('' + wd_dir + wd_name[i] + '/pascages/system/languages/'))

        gulp.src([
            'templates/**/' + wd_name[i] + '/*.*',
        ])
            .pipe(debug({title: '' + wd_name[i] + ':'}))
            .pipe(gulp.dest('' + wd_dir + wd_name[i] + '/pascages/templates/'))
    }
});

gulp.task('wdInstalZip', function() {

    var zip = require('gulp-zip');

    for (var i = 0; i < wd_name.length; i++) {
        gulp.src(['' + wd_dir + wd_name[i] + "/**/*.*", "!" + wd_dir + wd_name[i] + "/**/*.zip"])
            .pipe(zip('' + wd_name[i] + '.zip'))
            .pipe(gulp.dest('' + wd_dir + wd_name[i] + '/'))
    }
});

gulp.task('wdInit', ['wdInstall', 'wdInstalZip']);

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

gulp.task('clean', function () {
    return del([
        path.clean.style,
        path.clean.styleContr,
        path.clean.fonts,
    ]);
});

gulp.task('default', ['browser-sync', 'build', 'wdInit', 'watch']);