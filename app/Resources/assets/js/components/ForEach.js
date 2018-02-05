/**
 * https://jsperf.com/for-vs-foreach/37
 * https://coderwall.com/p/kvzbpa/don-t-use-array-foreach-use-for-instead
 */
export default function ForEach(array, callback, scope) {
  for (let i = 0; i < array.length; i += 1) {
    callback.call(scope, array[i], i);
  }
}
