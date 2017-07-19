/**
 * Suggestion API handler
 * @function getSuggests : get suggests list
 * @function addComment : add the comment of the selected suggestion (@params id,comment)
 * @function addSuggest : add a suggest to current user (@params content)
 * @function getComments : get the comments of specific suggest (@params suggId)
 * @return : Every function return a $http promise
 */

angular.module('MyApp')
  .factory('Sugg', function($http,BASE) {
   
    var urlEncodeHeader = {'Content-Type':'application/x-www-form-urlencoded',} ;

    var contentTransform = function(obj) {
      var str = [];
      for(var p in obj)
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      return str.join("&");
    };
    return {
      getSuggests: function() {
        return $http({
                  url : BASE.URL +"suggest" ,
                  method:'GET',
                  headers: urlEncodeHeader           
            });
      },
      addSuggest : function(content){
        return $http({
                  url : BASE.URL +"suggest/new",
                  method:'POST',
                  transformRequest: contentTransform,
                  data:{"suggest_content":content,"user_id":localStorage.getItem("id")},
                  headers:urlEncodeHeader
            });
      },
      addComment: function(id,comment) {
        return $http({
                url : BASE.URL +"suggest/"+id+"/comment" ,
                method:'POST',
                data:{"comment_content":comment,"user_id":localStorage.getItem("id")},
                transformRequest: contentTransform ,
                headers:urlEncodeHeader
            });
      },
      getComments: function(id){
        return $http({
                url : BASE.URL +"suggest/"+id+"/comments" ,
                method:'POST',
                headers:urlEncodeHeader
        });
      },
      deleteComment : function(id){
        return $http({
                url : BASE.URL +"comment/"+id+"/delete" ,
                method:'POST',
                headers:urlEncodeHeader
        });
      }
    };
  });