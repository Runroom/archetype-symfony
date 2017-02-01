'use strict';

import colors from 'colors';
import gulpLoadPlugins from 'gulp-load-plugins';
import _ from 'underscore';

const $ = gulpLoadPlugins({
    camelize: true,
    rename: {
        'gulp-util' : 'gutil'
    }
});

let kaomojies = {
    common :  '(」゜ロ゜)」',
    crazy :   '(⊙_◎)',
    default:  'ᶘ ᵒ㉨ᵒᶅ',
    fuck :    '(╯°□°）╯︵ ┻━┻',
    start :   '(ﾉ･ｪ･)ﾉ',
    yeah :    '＼（＠￣∇￣＠）／',
    writing : '＿〆(。。)'
};

let fn = {
    getKaomojies: (kaomoji) => {
        return kaomojies[kaomoji] || kaomojies.default;
    },
    consoleLog: (message, kaomoji) => {
        kaomoji = kaomoji || 'writing';
        $.gutil.log(fn.getKaomojies(kaomoji) +' '+ message);
    },
    // Keep old JS function because 'this' bind issue
    errorAlert: function(error) {
        let quotes       = $.gutil.colors.gray('\''),
            message      = 'Error compiling. '+ error.message +' ',
            fileName     = quotes + $.gutil.colors.cyan('Error') + quotes,
            errorKao     = fn.getKaomojies('fuck'),
            errorMessage = $.gutil.colors.red(message + errorKao);

        // $.notify.onError({
        //     title: 'You have an error!  ' + errorKao,
        //     message: 'Please, check your terminal.',
        //     sound: 'Sosumi'
        // })(error);
        fn.consoleLog(errorMessage, 'fuck');
        this.emit('end');
    },
    lintFormatter: (err) => {
        let errors = _.values(err),
            icons = {
                info: colors.blue('⬤'),
                success: colors.green('⬤'),
                warning: colors.yellow('⬤'),
                error: colors.red('⬤')
            },
            tab = '    ',
            space = ' ',
            line,
            has_errors = false;

        console.log();
        _.each(err, (value, key, list) => {
            let result = [];
            _.each(value.warnings, (v, k, l) => {
                if (v.text.trim() !== 'This file is ignored') {
                    result.push(v);
                }
            });

            if (result.length) {
                has_errors = true;
                console.log();
                console.log(space, colors.underline.white(value.source));
                _.each(value.warnings, (v, k, l) => {
                    line = (v.line) ? colors.gray(v.line + ':' + v.column) : '';
                    console.log(
                        tab,
                        icons[v.severity] + space,
                        line + space,
                        colors.white(v.text)
                    );
                });
                console.log();
            }
        });

        if (!has_errors) {
            console.log(
                tab,
                icons['success'] + space,
                colors.white('Yeah, no errors or warnings!')
            );
        }
        console.log();
    }
};

module.exports = fn;
