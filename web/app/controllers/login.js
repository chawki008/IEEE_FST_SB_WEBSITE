angular.module('MyApp')
  .controller('LoginCtrl', function($scope, $location, $auth, toastr) {
    $scope.loading = false ;
    $scope.login = function() {
      $scope.loading = true ;
      $auth.login($scope.user)
        .then(function() {
          $scope.loading = false ;
          toastr.success('You have successfully signed in!');
          $location.path('/');
        })
        .catch(function(error) {
          toastr.error(error.data.message, error.status);
        });
    };
  });
