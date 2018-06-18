const KAOMOJIES = {
  common: '(」゜ロ゜)」',
  crazy: '(⊙_◎)',
  default: 'ᶘ ᵒ㉨ᵒᶅ',
  fuck: '(╯°□°）╯︵ ┻━┻',
  start: '(ﾉ･ｪ･)ﾉ',
  yeah: '＼（＠￣∇￣＠）／',
  writing: '＿〆(。。)'
};

const getKaomojies = kaomoji => KAOMOJIES[kaomoji] || KAOMOJIES.default;

const message = (str, kaomoji) => {
  kaomoji = kaomoji || 'writing';
  console.log(`${getKaomojies(kaomoji)} ${str}`);
};

export { getKaomojies };
export default message;
