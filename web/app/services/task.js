/**
 * Tasks API handler
 *
 * @Author Tabib Ghaith
 *
 * @function getUserTasks 
 * @function getTaskUpdates  @params{id}
 * @function newTask  @params{content,deadline,users}
 * @function addUserToTask  @params{userId,taskId}
 * @function addUpdate  @params{taskId,content}
 * @function deleteUpdate @params{id}
 * @function deleteUserFromTask @params{userId,taskId}
 *
 * @Returns  Promise $http object
 */
angular.module('MyApp')
  .factory('task', function($http,BASE) {

  	var urlEncodeHeader = {'Content-Type':'application/x-www-form-urlencoded',} ;
    var contentTransform = function(obj) {
      var str = [];
      for(var p in obj)
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      return str.join("&");
    };
  	return {
  		getUserTasks : function(){
  			return $http({
  				url: BASE.URL+"user/"+localStorage.getItem("id")+"/tasks",
  				method:'GET',
  				headers:urlEncodeHeader
  			})
  		},
  		getTaskUpdates:function(id){
  			return $http({
  				url: BASE.URL+"task/"+id+"/updates",
  				method:'POST',
  				headers:urlEncodeHeader
  			})
  		},
  		newTask : function(content,deadLine,users){
  			return $http({
  				url: BASE.URL+"task/new",
  				method:'POST',
  				transformRequest: contentTransform,
          data:{"task_content":content,"deadline":deadLine,"users":users,"respo_id":localStorage.getItem("id")},
  				headers:urlEncodeHeader
  			})
  		},
  		addUserToTask : function(userId,taskId){
  			return $http({
  				url : BASE.URL+"task/"+taskId+"/addUser/"+userId,
  				method:"GET",
  				headers:urlEncodeHeader
  			});
  		},
  		addUpdate: function(taskId,content){
  			return $http({
  				url: BASE.URL+"task/"+taskId+"/update",
  				method:'POST',
  				transformRequest: contentTransform,
          data:{"update_content":content,"user_id":localStorage.getItem("id")},
  				headers:urlEncodeHeader
  			})
  		},
      deleteUpdate:function(id){
        return $http({
          url : BASE.URL+"update/"+id+"/delete",
          method:"GET",
          headers:urlEncodeHeader
        });
      },
      deleteUserFromTask:function(userId,taskId){
        return $http({
          url : BASE.URL+"task/"+taskId+"/deleteUser/"+userId,
          method:"GET",
          headers:urlEncodeHeader
        });
      }

  	}

  });