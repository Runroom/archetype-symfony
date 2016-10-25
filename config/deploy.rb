lock '3.5.0'

set :application, 'symfony_archetype'
set :repo_url, 'git@bitbucket.org:runroom/archetype-symfony.git'
set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader'
set :linked_dirs, fetch(:linked_dirs, []).push('app/logs', 'app/cache', 'vendor', 'web/bundles', 'web/uploads')
set :linked_files, fetch(:linked_files, []).push('app/config/parameters.yml', 'web/.htaccess', 'web/robots.txt')
set :use_sudo, false
set :keep_releases, 5

set :default_env, {
  'SYMFONY_ENV' => 'prod'
}

namespace :deploy do
  after :published, :symfony do
    on roles(:web) do
      within current_path do
        execute 'mv', 'app/cache/prod app/cache/prod_old'
        execute 'php', 'app/console doctrine:migrations:migrate --no-interaction'
        execute 'rm', '-rf app/cache/prod_old'
      end
    end
  end
end
