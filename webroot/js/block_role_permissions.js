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
NetCommonsApp.controller('BlockRolePermissions', ['$scope', function($scope) {

  /**
   * Not need approval
   *
   * @const
   */
  $scope.NOT_NEED_APPROVAL = '0';

  /**
   * Need both approval
   *
   * @const
   */
  $scope.NEED_APPROVAL = '1';

  /**
   * Need comment approval
   *
   * @const
   */
  $scope.NEED_COMMENT_APPROVAL = '2';

  /**
   * categories
   *
   * @type {integer}
   */
  $scope.useWorkflow = 0;

  /**
   * categories
   *
   * @type {integer}
   */
  $scope.useCommentApproval = 0;

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initializeRoles = function(data) {
    $scope.roles = data.roles;
  };

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initializeApproval = function(data) {
    $scope.initializeRoles(data);

    if (! angular.isUndefined(data.useWorkflow)) {
      $scope.useWorkflow = data.useWorkflow;
    }
    if (! angular.isUndefined(data.useCommentApproval)) {
      $scope.useCommentApproval = data.useCommentApproval;
    }
  };

  /**
   * Click role
   *
   * @return {void}
   */
  $scope.clickRole = function($event, permission, roleKey) {
    var baseRole = $scope.roles[roleKey];

    angular.forEach($scope.roles, function(role) {
      var element = $('input[type="checkbox"]' +
                      '[name="data[BlockRolePermission]' +
                      '[' + permission + ']' +
                      '[' + role['roleKey'] + ']' +
                      '[value]"]');

      if (! $event.currentTarget.checked) {
        if (Number(baseRole['level']) > Number(role['level'])) {
          if (! angular.isUndefined(element[0]) && ! element[0].disabled) {
            element[0].checked = false;
          }
        }
      } else {
        if (Number(baseRole['level']) < Number(role['level'])) {
          if (! angular.isUndefined(element[0]) && ! element[0].disabled) {
            element[0].checked = true;
          }
        }
      }
    });
  };

  /**
   * Click approval type
   *
   * @return {void}
   */
  $scope.clickApprovalType = function($event) {
    $scope.useWorkflow = 0;
    $scope.useCommentApproval = 0;
    if ($event.currentTarget.value === $scope.NEED_APPROVAL) {
      $scope.useWorkflow = 1;
    }
    if ($event.currentTarget.value === $scope.NEED_APPROVAL ||
            $event.currentTarget.value === $scope.NEED_COMMENT_APPROVAL) {
      $scope.useCommentApproval = 1;
    }
  };

}]);
