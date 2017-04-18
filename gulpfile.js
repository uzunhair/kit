"use strict";

var gulp = require('gulp'),
    cssnano = require('gulp-cssnano'),
    pxtorem = require('gulp-pxtorem'),
    autoprefixer = require('gulp-autoprefixer'),
    mqpacker = require('css-mqpacker'),
    sass = require('gulp-sass'),
    sassUnicode = require('gulp-sass-unicode'),  // Не допускает ошибок при наличии обратного слеша "\fff"
    sourcemaps = require('gulp-sourcemaps'),
    rigger = require('gulp-rigger'), // Собирает html файлы
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    del = require('del'), // Удаление файлов
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    changed = require('gulp-changed'), // запускают таски только для изменившихся файлов
    duration = require('gulp-duration'),
    browserSync = require('browser-sync').create();

// Setting


var site = 'kit',
    site_port = '3020',
    template = 'kit';

var user = '',
    password = '',
    host = '',
    ftp_port = 21,
    localFilesGlob = [
        'templates/' + template + '/**/*.*'
    ], remoteFolder = '/';

var path = {
    build: { //Тут мы укажем куда складывать готовые после сборки файлы
        html: 'app/',
        js: 'templates/' + template + '/js/',
        style: 'templates/' + template + '/css/',
        styleContr: 'templates/' + template + '/controllers/',
        img: 'templates/' + template + '/images/',
        fonts: 'templates/' + template + '/fonts/'
    },
    src: { //Пути откуда брать исходники
        html: 'app/*.html', //Синтаксис src/*.html говорит gulp что мы хотим взять все файлы с расширением .html
        js: 'templates/' + template + '/src/js/*.js',
        style: 'templates/' + template + '/src/sass/*.scss',
        styleDefault: 'templates/' + template + '/src/sass/default/*.css',
        styleContr: 'templates/' + template + '/src/sass/theme/controllers/*.scss',
        img: 'templates/' + template + '/images/**/*.*', //Синтаксис img/**/*.* означает - взять все файлы всех расширений из папки и из вложенных каталогов
        fonts: 'templates/' + template + '/src/fonts/**/*.*'
    },
    watch: { //Тут мы укажем, за изменением каких файлов мы хотим наблюдать
        html: 'app/**/*.html',
        js: 'templates/' + template + '/src/js/**/*.js',
        style: 'templates/' + template + '/src/sass/**/*.scss',
        img: 'templates/' + template + '/images/**/*.*',
        fonts: 'templates/' + template + '/src/fonts/**/*.*'
    },
    browser: {
        html: 'dist/**/*.html',
        php: 'templates/' + template + '/**/*.php',
        js: 'templates/' + template + '/js/**/*.js',
        style: 'templates/' + template + '/css/**/*.css',
        styleContr: 'templates/' + template + '/controllers/**/*.css',
        fonts: 'templates/' + template + '/fonts/**/*.*'
    },
    clean: {
        style: 'templates/' + template + '/css/**/*.*',
        styleContr: 'templates/' + template + '/controllers/**/*.+(css|map)',
        fonts: 'templates/' + template + '/fonts/**/*.*'
    }
};

gulp.task('browser-sync', ['watch'], function () {
    browserSync.init({
        proxy: site,
        port: site_port,
        logPrefix: "Kit",
        logConnections: true,
        notify: false,
        reloadDebounce: 500
    });

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
        .pipe(plumber())
        .pipe(concat('kit.js'))
        .pipe(uglify())
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
        .pipe(browserSync.stream({match: "**/*.min.css"}))
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
            path.dirname += "/" + path.basename + "";
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
        imageminJR = require('imagemin-jpeg-recompress'),
        imageminSvgo = require('imagemin-svgo');

    gulp.src(path.src.img) //Выберем наши картинки
        .pipe(changed(path.build.img))
        .pipe(plumber())
        .pipe(imagemin([
            imageminJR({
                method: 'ms-ssim'
            }),
            imageminSvgo({
                plugins: [
                    {removeViewBox: false}
                ]
            }),
            imageminOptipng({
                optimizationLevel: 5
            }),
            imageminGifsicle({
                interlaced: true
            })
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

// helper function to build an FTP connection based on our configuration
function getFtpConnection() {
    return ftp.create({
        host: host,
        port: ftp_port,
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
if (controller) {
    var wd_path = "/controllers/kitdeveloper";
}
else {
    var wd_path ;
}

gulp.task('wdAdd', function () {
    gulp.src("appkit/" + wd_add + "/pascages/system/languages/ru/controllers/kitdeveloper/widgets/wd.name.php")
        .pipe(rename({basename: '' + wd_add + ''}))
        .pipe(debug({title: '' + wd_add + ':'}))
        .pipe(gulp.dest("./dg/system/languages/ru" + wd_path + "/widgets/"))
    gulp.src("appkit/" + wd_add + "/pascages/system/controllers/kitdeveloper/widgets/wd.base/*.*")
        .pipe(debug({title: '' + wd_add + ':'}))
        .pipe(gulp.dest("./dg/system" + wd_path + "/widgets/" + wd_add + "/"))
    gulp.src("appkit/" + wd_add + "/pascages/templates/kit/controllers/kitdeveloper/widgets/wd.base/*.*")
        .pipe(debug({title: '' + wd_add + ':'}))
        .pipe(gulp.dest("./dg/templates/kit/" + wd_path + "/widgets/" + wd_add + "/"))
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

gulp.task('wdInstalZip', function () {

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

gulp.task('default', ['browser-sync', 'build', 'watch']);

// task для замены текста, необходимо доработать.
gulp.task('templates', function(){

var replace = require('gulp-replace'),
    scan = require('gulp-scan');

    gulp.src(['system/**/*.*'])
        .pipe(scan({ term: 'THEME_KIT', fn: function (match, file) {
            // do something with {String} `match`
            // `file` is a clone of the vinyl file.
        }}))
        .pipe(replace('THEME_KIT', 'THEME_MY_NAME'))
        .pipe(gulp.dest('build/'));
});