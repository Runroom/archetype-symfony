# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'gpcasinos_web'
set :repo_url, 'git@bitbucket.org:runroom/gpcasinos_web.git'

set :use_composer, true
set :update_vendors, true
set :vendors_mode, 'install'
set :linked_dirs, fetch(:linked_dirs, []).push('app/logs', 'app/cache', 'vendor')
set :linked_files, fetch(:linked_files, []).push('app/config/parameters.yml')
set :use_sudo, false
set :keep_releases, 5

namespace :deploy do

  after :updating, :create_release do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # fetch(:linked_dirs).each do |dir|
      #   source = shared_path.join(dir)
      #   execute 'chmod', "g+w #{source}"
      # end
    end
  end

  after :updated, :migrate do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # within release_path do
      #   execute 'php', 'bin/doctrine-dbal migrations:migrate  --no-interaction'
      # end
      # execute 'rm', "-f #{shared_path}/cache/class_index.php"
    end
  end

end
