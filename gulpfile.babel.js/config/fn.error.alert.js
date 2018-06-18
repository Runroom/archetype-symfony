import colors from 'colors';
import message, { getKaomojies } from './fn.message';

// Keep old JS function because 'this' bind issue
const errorAlert = function(error) {
  const str = `Error compiling. ${error.message} ${getKaomojies('fuck')}`;
  message(colors.red(str), 'fuck');
  this.emit('end');
};

export default errorAlert;
