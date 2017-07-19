/**
 * Tasks Handler 
 * 
 */

angular.module('MyApp')
  .controller('TasksCtrl', function($scope,task,Account,toastr){
    $scope.formUsers = []; 
    $scope.prettyDate = function(date){
      var monthNames = [
      "January", "February", "March",
      "April", "May", "June", "July",
      "August", "September", "October",
      "November", "December"
      ];
      var dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
      var date = new Date(date);
      var day = date.getDate();
      var monthIndex = date.getMonth();
      var year = date.getFullYear();
      return dayNames[date.getDay()]+", "+day+" "+monthNames[monthIndex]+" "+year ;
    }

    $scope.userId = localStorage.getItem("id") ;
  	$scope.tasks = [] ;
    $scope.selectedUsersList = [];
    $scope.selectedTask = 0 ;
    $scope.updates = [];
    $scope.loading = true ;
    $scope.empty  = false ;
  	$scope.getClass = function(id){
      if (id ==$scope.selectedTask) return "active" ;
      return "";
    }

    $scope.changeTask = function(id){
      $scope.selectedTask = id ;
      $scope.selectedUsersList = [];
      $scope.refresh();
    }
  	$scope.getTasks = function(){
  		task.getUserTasks().then(function(response){
        if (response.data == []){
          $scope.loading = false ;
          $scope.empty  = true ;

        } else {
          $scope.tasks = response.data ;
          getUserList();
          $scope.getUpdates();
        }
        
  		},function(response){
  			toastr.error("Can't load tasks");
  		})
  	}
    var getUserList = function(){
      $scope.selectedUsersList = [];
      var usersObj = $scope.tasks[$scope.selectedTask].usersId ; 
      var usersId = [];
      angular.forEach(usersObj, function(value,key){
        var user  = {};
        Account.getProfile(key).then(function(response){
          user = Account.formatData(key,response.data) ;
          $scope.selectedUsersList.push(user);
        },function(response){
          toastr.error("Can't Users " + response.data);
        })
      });

    }
    $scope.getUpdates = function(){
      task.getTaskUpdates($scope.tasks[$scope.selectedTask].id).then(function(response){
        $scope.updates = [] ;
        $scope.loading = false ; 
        angular.forEach(response.data,function(value,key){
          $scope.updates.push({
              "id":key,
              "userId":value[3],
              "content":value[0],
              "username":value[2],
              "date":value[1].split("-").reverse().join("-")
          })
        });
      },function(response){
        toastr.error("Can't load updates");
      })
    }
    $scope.searchUser = function(query) {  
      return Account.searchUsername(query);
    }
    $scope.refresh = function(){
      $scope.loading = true ;
      $scope.getTasks();
    }
    $scope.addUpdate = function(content){
      if(angular.isUndefined(content)) {
        toastr.error("Empty update , try again !");
        return -1 ; 
      }
      task.addUpdate($scope.tasks[$scope.selectedTask].id,content).then(function(response){
        $scope.refresh();
        toastr.success("Update added");
      },function(response){
        toastr.error(response.data);
      });
    }
    $scope.deleteUpdate = function(id){
      task.deleteUpdate(id).then(function(response){
        $scope.refresh();
        toastr.success("Update deleted");
      },function(response){
        toastr.error(response.data);
      })
    }
    $scope.deleteUser = function(id){
      $scope.refresh();
      task.deleteUserFromTask(id,$scope.tasks[$scope.selectedTask].id).then(function(response){
        toastr.success("User removed from task");
      },function(response){toastr.error(response.data);});
    }
    $scope.addUser = function(id){
      task.addUserToTask(id,$scope.tasks[$scope.selectedTask].id).then(
        function(response){$scope.refresh();}
        ,function(response){toastr.error(response.data);}
      );
    };
    function arrayObjectIndexOf(myArray, searchTerm, property) {
        for(var i = 0, len = myArray.length; i < len; i++) {
            if (myArray[i][property] === searchTerm) return i;
        }
        return -1;
    }
    $scope.selectUser = function(id){
      var ind = arrayObjectIndexOf($scope.formUsers, id, "id");
      if (id ==localStorage.getItem("id")){
        toastr.error("Don't select your self");
        return - 1 ;
      }
      if (ind == -1) {
        Account.getProfile(id).then(function(response){
            user = Account.formatData(id,response.data) ;
            $scope.formUsers.push(user);
          },function(response){
            toastr.error("Can't Users " + response.data);
          });
        return -2 ;
      }
      toastr.error("User already selected"); 
    }
    $scope.deselectUser = function(id){
      var ind = arrayObjectIndexOf($scope.formUsers, id, "id");
      if (ind > -1) {
        $scope.formUsers.splice(ind, 1);
      }
    }
    $scope.newTask = function(){
      $scope.task.users = [];
      angular.forEach($scope.formUsers,function(value,key){
          $scope.task.users.push(value.id);
        });
      task.newTask($scope.task).then(function(response){toastr.success("task added");},
        function(response){toastr.error("Can't ->" + response.data);});
    }
    $scope.getTasks();

  });