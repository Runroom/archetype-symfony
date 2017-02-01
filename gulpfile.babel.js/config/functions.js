'use strict';

import colors from 'colors';
import gulpLoadPlugins from 'gulp-load-plugins';
import _ from 'underscore';

const $ = gulpLoadPlugins({ camelize: true });

let kaomojies = {
    common: '(」゜ロ゜)」',
    crazy: '(⊙_◎)',
    default: 'ᶘ ᵒ㉨ᵒᶅ',
    fuck: '(╯°□°）╯︵ ┻━┻',
    start: '(ﾉ･ｪ･)ﾉ',
    yeah: '＼（＠￣∇￣＠）／',
    writing: '＿〆(。。)'
};

let fn = {
    getKaomojies: (kaomoji) => {
        return kaomojies[kaomoji] || kaomojies.default;
    },
    consoleLog: (message, kaomoji) => {
        kaomoji = kaomoji || 'writing';
        $.util.log(fn.getKaomojies(kaomoji) +' '+ message);
    },
    // Keep old JS function because 'this' bind issue
    errorAlert: function(error) {
        let message      = 'Error compiling. '+ error.message +' ',
            errorKao     = fn.getKaomojies('fuck');

        fn.consoleLog($.util.colors.red(message + errorKao), 'fuck');
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
