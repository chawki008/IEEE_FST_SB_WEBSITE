angular.module('MyApp')
  .controller('ProfileCtrl', function($scope, $auth, toastr, Account) {
    $scope.getProfile = function(id) {
      Account.getProfile(id)
        .then(function(response) {
          $scope.user = Account.formatData(id ,response.data);
        })
        .catch(function(response) {
          toastr.error(response.data.message, response.status);
        });
    };
    $scope.updateProfile = function() {
      Account.updateProfile($scope.user)
        .then(function() {
          toastr.success('Profile has been updated');
        })
        .catch(function(response) {
          toastr.error(response.data.message, response.status);
        });
    };
   

    $scope.getProfile(localStorage.getItem("id"));
  });
