/* eslint-disable */
import { render } from '../config/testing-utils';

describe('Billboard', () => {
  it('Should render a Billboard with provided data', async () => {
    const title = 'This is the title';
    const description = 'This is the description';
    const image = 'https://picsum.photos/1200/600';
    const attributes = 'data-testid="billboard"';

    const { getByTestId } = await render(
      './templates/components/billboard.html.twig', { component: { attributes, title, description, image } }
    );

    expect(getByTestId('billboard')).toHaveAttribute('style', `background-image:url(${image});`);
    expect(getByTestId('billboard')).toHaveTextContent(title);
    expect(getByTestId('billboard')).toHaveTextContent(description);
  });

  it('Should render a Billboard with missing provided data', async () => {
    const title = 'This is the title';
    const description = 'This is the description';
    const attributes = 'data-testid="billboard"';

    const { getByTestId, queryByText } = await render(
      './templates/components/billboard.html.twig', { component: { attributes, title } }
    );

    expect(getByTestId('billboard')).not.toHaveAttribute('style');
    expect(getByTestId('billboard')).toHaveTextContent(title);
    expect(queryByText(description)).toBeNull();

  });
});
