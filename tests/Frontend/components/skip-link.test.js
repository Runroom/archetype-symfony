/* eslint-disable */
import { render } from '../config/testing-utils';

describe('Skip links', () => {
  it('Should render link with provided data', async () => {
    const title = 'This is a skip link';
    const target = '#anchor-target';
    const attributes = 'data-testid="skip-link"';

    const { getByTestId } = await render(
      './templates/components/skip-link.html.twig', { component: { attributes, target, title } }
    );

    expect(getByTestId('skip-link')).toHaveAttribute('href', target);
    expect(getByTestId('skip-link')).toHaveTextContent(title);
  });

  it('Should not render skip link', async () => {
    const title = 'This is a skip link';

    const { queryByText } = await render(
      './templates/components/skip-link.html.twig', { component: { title } }
    );

    expect(queryByText(title)).toBeNull();
  });
});
