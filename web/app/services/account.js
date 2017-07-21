/**
 * @Author Tabib Ghaith
 *
 *  Account API handler web services
 *
 */
angular.module('MyApp')
  .factory('Account', function($http,BASE) {
    var urlEncodeHeader = {'Content-Type':'application/x-www-form-urlencoded',} ;
    return {
      getProfile: function(id) {
        return $http({
                  url : BASE.URL +"user/"+id ,
                  method:'GET',
                  headers: urlEncodeHeader           
            });
      },
      formatData : function(id,user){
        return {"id" : id , "username":user[id][0].username,"img":user[id][0].image};
      },
      searchUsername : function(query){
        if (!angular.isDefined(query)) return -1 ;
        return $http({
                  url : BASE.URL +"user/search/"+query,
                  method:'GET',
                  headers: urlEncodeHeader           
            });
      },
      updateProfile: function(profileData) {
        return $http.put('/api/me', profileData);
      }
    };
  });