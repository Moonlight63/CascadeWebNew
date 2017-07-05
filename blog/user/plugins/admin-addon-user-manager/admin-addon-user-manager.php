<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use \Grav\Common\Utils;
use \Grav\Common\User\User;

class AdminAddonUserManagerPlugin extends Plugin {

  const SLUG = 'admin-addon-user-manager';
  const PAGE_LOCATION = 'user-manager';
  const CONFIG_KEY = 'plugins.' . self::SLUG;

  public static function getSubscribedEvents() {
    return [
      'onPluginsInitialized' => ['onPluginsInitialized', 0]
    ];
  }

  public function onPluginsInitialized() {
    if (!$this->isAdmin() || !$this->grav['user']->authenticated) {
      return;
    }

    $this->enable([
      'onAdminTwigTemplatePaths' => ['onAdminTwigTemplatePaths', 0],
      'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
      'onAdminMenu' => ['onAdminMenu', 0],
      'onAssetsInitialized' => ['onAssetsInitialized', 0],
      'onAdminTaskExecute' => ['onAdminTaskExecute', 0],
    ]);
  }

  public function onAssetsInitialized() {
    $this->grav['assets']->addCss('plugin://' . self::SLUG . '/assets/style.css');
  }

  public function onAdminMenu() {
    $twig = $this->grav['twig'];
    $twig->plugins_hooked_nav = (isset($twig->plugins_hooked_nav)) ? $twig->plugins_hooked_nav : [];
    $twig->plugins_hooked_nav['User Manager'] = [
      'location' => self::PAGE_LOCATION,
      'icon' => 'fa-user',
      'authorize' => 'admin.users',
    ];
  }

  public function onAdminTwigTemplatePaths($e) {
    $paths = $e['paths'];
    $paths[] = __DIR__ . DS . 'templates';
    $e['paths'] = $paths;
  }

  public function onTwigSiteVariables() {
    $twig = $this->grav['twig'];
    $page = $this->grav['page'];
    $uri = $this->grav['uri'];

    if ($page->slug() !== self::PAGE_LOCATION) {
      return;
    }

    $page = $this->grav['admin']->page(true);
    $twig->twig_vars['context'] = $page;
    $twig->twig_vars['users'] = $this->users();
    $twig->twig_vars['fields'] = $this->config->get(self::CONFIG_KEY . '.modal.fields');
  }

  public function onAdminTaskExecute($e) {
    $method = $e['method'];

    if ($method === "taskUserDelete") {
      $page = $this->grav['admin']->page(true);
      $username = $this->grav['uri']->paths()[2];
      $user = User::load($username);
      
      if ($user->file()->exists()) {
        $user->file()->delete();
        $this->grav->redirect('/' . $this->grav['admin']->base . '/' . self::PAGE_LOCATION);
        return true;
      }
    }

    return false;
  }

  public function users() {
    $users = [];

    $dir = $this->grav['locator']->findResource('account://');
    $files = $dir ? array_diff(scandir($dir), ['.', '..']) : [];
    foreach ($files as $file) {
      if (Utils::endsWith($file, YAML_EXT)) {
        $user = User::load(trim(pathinfo($file, PATHINFO_FILENAME)));
        $users[$user->username] = $user;
      }
    }

    return $users;
  }

}
