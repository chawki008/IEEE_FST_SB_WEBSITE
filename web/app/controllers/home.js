angular.module('MyApp')
  .controller('HomeCtrl', function($scope, $http,toastr,Sugg) {

    $scope.loading = true;
	$scope.suggestions = [];
	$scope.commentsView = {} ;
	$scope.currentPage = 1;
	$scope.pageSize = 10 ;
	$scope.view = {} ;
	$scope.comment = "" ;

	$scope.prettyDate = function(date){
	    var monthNames = [
	  	"January", "February", "March",
	  	"April", "May", "June", "July",
	  	"August", "September", "October",
	  	"November", "December"
		];
   		var dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
		var date = new Date(date.split("-").reverse().join("-"));
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		return dayNames[date.getDay()]+", "+day+" "+monthNames[monthIndex]+" "+year ;
	}
	var searchArray = function(id,tab){
		var i ;
		for (i =0;i <tab.length;i++){
			if (id == tab[i].suggId) return i ;
		}
		return -1 ;
	}
	
	$scope.getSuggests = function(){
		Sugg.getSuggests().then(
			function(response){
				$scope.suggestions = [];
				$scope.suggestionsStatus =[];
				angular.forEach(response.data, function(value,key){
					var suggest = {} ;
					suggest.suggId = key ;	
					suggest.title = value[0] ;
					suggest.date = value[1];
					suggest.user = {"username" : value[2],
									"id" : value[3],
									"img" : value[4]
									} ;			
					$scope.suggestions.push(suggest);
					$scope.view[key] = "open";
				});
				$scope.loading = false ;
			},
			function(response){
				window.console.log(response);
				alert(response.status) ;
			}
		);	
	}
	
	$scope.addSuggest = function(content){
		if (angular.isUndefined(content)){
			toastr.error("Empty Suggest");
		} else {
			Sugg.addSuggest(content).then(function(response){
				toastr.success('Suggest Submitted');
				$scope.getSuggests();
			},function(response){
				toastr.error(response.data);
			})
		}
	}
	$scope.addComment = function(id,comment){
		Sugg.addComment(id,comment).then(function(response){
        	toastr.success('Comment Submitted');
        	$scope.getComments(id);
        	$scope.comment = "" ;
        });
	}
	$scope.getComments = function(id){
		
		Sugg.getComments(id).then(function(response){
        	var index  = searchArray(id,$scope.suggestions);
        	$scope.suggestions[index].comments = [];
        	angular.forEach(response.data, function(value,key){
				var comment = {} ;
				comment.id = key ;	
				comment.content = value[1] ;
				comment.date = value[2];
				comment.user = {"id":value[4],
								"username":value[3],
								"img":value[5]
								} ;			
				$scope.suggestions[index].comments.push(comment);
			});
        	//toastr.success('Comments Loaded');
        },function(response){
        	toastr.error("Can't get the Comments of suggestion "+id);
        });
	}	
	$scope.userComment =  function(userId){
		if (userId == localStorage.getItem("id"))return true ; 
		return false 
	};
	$scope.deleteComment = function(id,suggId){
		Sugg.deleteComment(id).then(function(response){
			toastr.success('Comment deleted');
			$scope.getComments(suggId);
		},function(response){
			toastr.error("Can't delete the comment "+response.data);
		})
	};
	$scope.changeView = function(id){
		$scope.view[id] = $scope.view[id] == "open" ? "close" : "open" ;
	}
	$scope.getSuggests();
  });
