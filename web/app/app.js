angular.module('MyApp', ['angularUtils.directives.dirPagination','ngResource', 'ngMessages', 'ngAnimate', 'toastr', 'ui.router', 'satellizer','angular-page-loader'])
  .config(function($stateProvider, $urlRouterProvider, $authProvider,BASE) {
    /**
     * Config url
     */
    $authProvider.baseUrl = BASE.URL;
    $authProvider.loginUrl = BASE.LOGIN;
    $authProvider.signupUrl = BASE.SIGNUP;
    /**
     * Helper auth functions
     */
    var skipIfLoggedIn = function($q, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        deferred.reject();
      } else {
        deferred.resolve();
      }
      return deferred.promise;
    };

    var loginRequired = function($q, $location, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        deferred.resolve();
      } else {
        $location.path('/login');
      }
      return deferred.promise;
    };

    /**
     * App routes
     */
    $stateProvider
      .state('home', {
        url: '/',
        controller: 'HomeCtrl',
        templateUrl: 'http://localhost:8000/app/partials/home.html',
        resolve: {
          loginRequired: loginRequired
        }
      })
      .state('tasks', {
        url: '/tasks',
        controller: 'TasksCtrl',
        templateUrl: 'http://localhost:8000/app/partials/tasks.html',
        resolve: {
          loginRequired: loginRequired
        }
      })
      .state('login', {
        url: '/login',
        templateUrl: 'http://localhost:8000/app/partials/login.html',
        controller: 'LoginCtrl',
        resolve: {
          skipIfLoggedIn: skipIfLoggedIn
        }
      })
      .state('signup', {
        url: '/signup',
        templateUrl: 'http://localhost:8000/app/partials/signup.html',
        controller: 'SignupCtrl',
        resolve: {
          skipIfLoggedIn: skipIfLoggedIn
        }
      })
      .state('logout', {
        url: '/logout',
        template: null,
        controller: 'LogoutCtrl'
      })
      .state('profile', {
        url: '/profile',
        templateUrl: 'http://localhost:8000/app/partials/profile.html',
        controller: 'ProfileCtrl',
        resolve: {
          loginRequired: loginRequired
        }
      });
    $urlRouterProvider.otherwise('/');

   
  });
/**
 *  constant vars
 *  @vars : BASE{URL}
 */
angular.module('MyApp').constant("BASE", {
        "URL": "http://localhost:8000/",
        "LOGIN":"auth",
        "SIGNUP":"auth/signup",
    });

