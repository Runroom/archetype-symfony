module.exports = {
    src: {
        base: 'app/Resources',
        fonts: 'app/Resources/assets/fonts',
        img: 'app/Resources/assets/img',
        js: 'app/Resources/assets/js',
        sprites: 'app/Resources/assets/img/sprites',
        scss: 'app/Resources/assets/scss'
    },
    dist: {
        base: 'web',
        css: 'web/assets/css',
        fonts: 'web/assets/fonts',
        img: 'web/assets/img',
        js: 'web/assets/js',
        sprites: 'web/assets/img/sprites'
    },
    bower: {
        copy: [],
        concat: [
            'bower_components/svg4everybody/dist/svg4everybody.min.js'
        ]
    }
};
