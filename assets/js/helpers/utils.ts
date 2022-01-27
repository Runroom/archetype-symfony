const preloadImage = (url: string) =>
  new Promise((resolve, reject) => {
    const image = new Image();
    image.src = url;
    image.onload = resolve;
    image.onerror = reject;
  });

export { preloadImage };
