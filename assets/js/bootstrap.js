import { startStimulusApp } from '@symfony/stimulus-bridge';

// eslint-disable-next-line import/prefer-default-export
export const app = startStimulusApp(require.context(
  '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
  true,
  /\.(j|t)sx?$/
));
