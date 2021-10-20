/* eslint-disable */
import { render } from '../config/testing-utils';

describe('Back link functionallity', () => {
  it('Should have correct data', async () => {
    const { getByTestId } = await render(
      './templates/components/skip-link.html.twig',
      {
        target: 'google.com',
        title: 'Google'
      }
    );

    expect(getByTestId('skip-link')).toHaveAttribute('href', 'google.com');
    expect(getByTestId('skip-link')).toHaveTextContent('Google');
  });
});
