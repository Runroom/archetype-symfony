# Configuration

The BaseBundle included in the Archetype allows you to change the default
PageViewModel using a configuration variable.

If you need to replace the default PageViewModel you'll need to implement the
`Runroom\BaseBundle\ViewModel\PageViewModelInterface` interface in your view model.
Then you can configure the BaseBundle like so:

```
runroom_base:
    page_view_model: 'Runroom\BaseBundle\ViewModel\PageViewModel'
```
