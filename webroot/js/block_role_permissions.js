/**
 * @fileoverview BlockRolePermissions Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * BlockRolePermissions Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('BlockRolePermissions', function($scope) {

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    console.log(data);


    $scope.roles = data.roles;
    $scope.frameId = data.frameId;
  };

  /**
   * Set more than level
   *
   * @return {void}
   */
  $scope.clickRole = function($event, permission, roleKey) {
//    console.log($event);
//    console.log(permission);
//    console.log(roleKey);
//
//    console.log($event.currentTarget.checked);
    var baseRole = $scope.roles[roleKey];



//      if (! angular.isUndefined(element[0]) &&
//              ! angular.isUndefined(data['title'])) {
//        element[0].value = data['title'];
//      }



    angular.forEach($scope.roles, function(role) {
      //console.log(key);
      //console.log(role);
      var element = $('input[type="checkbox"][name="data[BlockRolePermission][' + permission + '][' + role['roleKey'] + '][value]"]');
      if (! $event.currentTarget.checked) {
        if (baseRole['level'] > role['level']) {
          if (! angular.isUndefined(element[0]) && ! element[0].disabled) {
            element[0].checked = false;
          }
        }
      } else {
        if (baseRole['level'] < role['level']) {
          if (! angular.isUndefined(element[0]) && ! element[0].disabled) {
            element[0].checked = true;
          }
        }
      }
    });

  };

});
