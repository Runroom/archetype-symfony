/* eslint-disable */
import { render } from '../config/testing-utils';

describe('Basic page', () => {
  it('Should render a basic page with provided data', async () => {
    const title = 'This is the title';
    const content = '<h2>This is the subtitle</2><p>This is the description paragraph 1</p><p>This is the description paragraph 1</p>';

    const { getByTestId, queryByText } = await render(
      './templates/bundles/RunroomBasicPageBundle/show.html.twig', {
        app: {
          request: {
            locale: 'en'
          }
        },
        model: {
          basicPage: {
            title,
            content
          }
        }
      }
    );

    expect(queryByText(title)).not.toBeNull();
    expect(getByTestId('header')).not.toBeNull();
  });
});
