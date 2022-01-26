import path from 'path';

const basePath = path.resolve(__dirname, '..', '..', '..');

const testNamespaces = {
  components: `${basePath}/templates/components`,
  modules: `${basePath}/templates/modules`,
  helpers: `${basePath}/templates/helpers`,
  bundles: `${basePath}/templates/bundles`,
  layouts: `${basePath}/templates/layouts`,
  RunroomSeo: `${basePath}/templates/bundles/RunroomSeoBundle`,
  '!RunroomSeo': `${basePath}/vendor/runroom-packages/seo-bundle/src/Resources/views`
};

export default testNamespaces;
