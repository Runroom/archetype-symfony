'use strict';

import plugins from 'gulp-load-plugins';
import es from 'event-stream';

const $ = plugins({
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
    errorAlert: (error) => {
        let quotes       = $.gutil.colors.gray('\''),
            message      = 'Error compiling. '+ error.message +' ',
            fileName     = quotes + $.gutil.colors.cyan('Error') + quotes,
            errorKao     = fn.getKaomojies('fuck'),
            errorMessage = $.gutil.colors.red(message + errorKao);

    	$.notify.onError({
            title: 'You have an error!  ' + errorKao,
            message: 'Please, check your terminal.',
            sound: 'Sosumi'
        })(error);
    	fn.consoleLog(errorMessage, 'fuck');
    }
};

module.exports = fn;
