# config valid only for current version of Capistrano
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
  after :updated, :migrate do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      within release_path do
        execute 'php', 'app/console doctrine:migrations:migrate --no-interaction'
      end
    end
  end

  after :published, :cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      within release_path do
        execute 'mv', 'app/cache/prod app/cache/prod_old'
        execute 'rm', '-rf app/cache/prod_old'
      end
    end
  end
end
