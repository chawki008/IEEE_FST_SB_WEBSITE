/**
 * @Author Ghaith Tabib 
 */
angular.module('MyApp')
    .directive('typeahead', function(BASE,toastr) {
      return {
        restrict: 'E',
        scope: {
                updateFn: '&',
                refreshFn :'&',
                adduserFn :'&',
                ngModel: '=',
                ngDisabled:'=',
                taskId:'='
        },
        link: function(scope, elem, attrs) {
            scope.placeHolder = attrs.placeHolder ;
            scope.iClass = attrs.iClass;
            scope.items = [];
            scope.loading = false ;
            scope.searchFn = function(msg){
                scope.loading = true ; 
                if (angular.isUndefined(msg)) {
                    scope.loading = false ;
                    return -1 ;
                }
                scope.updateFn({msg : msg}).then(function(response){
                    scope.loading = false ;
                    scope.items = response.data ;
                })
            };
            scope.selectUser = function(id){
                scope.adduserFn({id : id});      
                scope.items = [];         
            }
            

        },
        templateUrl: BASE.URL+'app/partials/search.html'
      };
    });
angular.module('MyApp').directive('myEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});
