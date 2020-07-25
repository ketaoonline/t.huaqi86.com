<?php
// +----------------------------------------------------------------------
// | test [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.zzstudio.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Byron Sampson <xiaobo.sun@gzzstudio.net>
// +----------------------------------------------------------------------
namespace addons\Nsfx;

use addons\BaseConfig;
class Config extends BaseConfig
{
    /**
     * 菜单设置
     */
    public function menu(){
        $menu = [
            [
                'module_name' => '分销',
                'controller' => 'distribution',
                'method' => 'promoterList',
                'parent' => [],
                'url' => 'distribution/promoterList',
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 5,
                'desc' => '分销',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
                'child'   =>[
                    [
                    'module_name' => '分销商列表',
                    'controller' => 'distribution',
                    'method' => 'promoterList',
                    'url' => 'Distribution/promoterList',
                    'is_menu' => 1,
                    'is_dev' => 0,
                    'sort' => 4,
                    'desc' => '分销商管理',
                    'module_picture' => '',
                    'icon_class' => '',
                    'is_control_auth' => 1,
                    'child' =>[
                        [
                            'module_name' => '修改分销商父级',
                            'controller' => 'Distribution',
                            'method' => 'modifyPrometerParent',
                            'url' => 'Distribution/modifyPrometerParent',
                            'is_menu' => 0,
                            'is_dev' => 0,
                            'sort' => 1,
                            'desc' => '修改分销商父级',
                            'module_picture' => '',
                            'icon_class' => '',
                            'is_control_auth' => 1
                        ],
                        [
                            'module_name' => '分销商',
                            'controller' => 'Distribution',
                            'method' => 'promoterList',
                            'url' => 'Distribution/promoterList',
                            'is_menu' => 1,
                            'is_dev' => 0,
                            'sort' => 1,
                            'desc' => '分销商',
                            'module_picture' => '',
                            'icon_class' => '',
                            'is_control_auth' => 1
                        ],
                        [
                            'module_name' => '待审核',
                            'controller' => 'Distribution',
                            'method' => 'promoterAuditList',
                            'url' => 'Distribution/promoterAuditList',
                            'is_menu' => 1,
                            'is_dev' => 0,
                            'sort' => 3,
                            'desc' => '待审核',
                            'module_picture' => '',
                            'icon_class' => '',
                            'is_control_auth' => 1
                        ],
                        [
                            'module_name' => '账户详情',
                            'controller' => 'Distribution',
                            'method' => 'promoterAccount',
                            'url' => 'Distribution/promoterAccount',
                            'is_menu' => 1,
                            'is_dev' => 0,
                            'sort' => 4,
                            'desc' => '分销商账户详情',
                            'module_picture' => '',
                            'icon_class' => '',
                            'is_control_auth' => 1
                        ]
                         
                    ]
                    ],
                    [
                        'module_name' => '分销设置',
                        'controller' => 'Distribution',
                        'method' => 'threeLevelDistributionConfig',
                        'url' => 'Distribution/threeLevelDistributionConfig',
                        'is_menu' => 1,
                        'is_dev' => 0,
                        'sort' => 6,
                        'desc' => '三级分销',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                         
                    ],
                    [
                        'module_name' => '分销等级',
                        'controller' => 'Distribution',
                        'method' => 'promoterLevelList',
                        'url' => 'Distribution/promoterLevelList',
                        'is_menu' => 1,
                        'is_dev' => 0,
                        'sort' => 7,
                        'desc' => '分销商等级',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                        'child' =>
                        [
                            [
                                'module_name' => '分销商等级修改',
                                'controller' => 'Distribution',
                                'method' => 'updatePromoterLevel',
                                'url' => 'Distribution/updatePromoterLevel',
                                'is_menu' => 0,
                                'is_dev' => 0,
                                'sort' => 1,
                                'desc' => '分销商等级修改',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ],
                             
                            [
                                'module_name' => '分销商等级添加',
                                'controller' => 'Distribution',
                                'method' => 'addPromoterLevel',
                                'url' => 'Distribution/addPromoterLevel',
                                'is_menu' => 0,
                                'is_dev' => 0,
                                'sort' => 2,
                                'desc' => '分销商等级添加',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ],
                             
                        ]
                    ],
                    [
                        'module_name' => '区域分销',
                        'controller' => 'Distribution',
                        'method' => 'regionalAgent',
                        'url' => 'Distribution/regionalAgent',
                        'is_menu' => 1,
                        'is_dev' => 0,
                        'sort' => 7,
                        'desc' => '区域分销',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                        'child' =>
                        [
                            [
                                'module_name' => '区域分销配置',
                                'controller' => 'Distribution',
                                'method' => 'UpdateShopRegionAgentConfig',
                                'url' => 'Distribution/UpdateShopRegionAgentConfig',
                                'is_menu' => 0,
                                'is_dev' => 0,
                                'sort' => 1,
                                'desc' => '区域分销配置',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ],
                            [
                                'module_name' => '用户管理',
                                'controller' => 'Distribution',
                                'method' => 'promoterRegionAgentList',
                                'url' => 'Distribution/promotelRegionAgentList',
                                'is_menu' => 0,
                                'is_dev' => 0,
                                'sort' => 1,
                                'desc' => '用户管理',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ]
                        ]
                    ],
                    [
                        'module_name' => '股东分红',
                        'controller' => 'Distribution',
                        'method' => 'shareholderDividendsConfig',
                        'url' => 'Distribution/shareholderDividendsConfig',
                        'is_menu' => 1,
                        'is_dev' => 0,
                        'sort' => 8,
                        'desc' => '股东分红',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1,
                        'child' =>
                        [
                            [
                                'module_name' => '基本设置',
                                'controller' => 'Distribution',
                                'method' => 'shareholderDividends',
                                'url' => 'Distribution/shareholderDividends',
                                'is_menu' => 1,
                                'is_dev' => 0,
                                'sort' => 1,
                                'desc' => '基本设置',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ],
                            [
                                'module_name' => '股东等级',
                                'controller' => 'Distribution',
                                'method' => 'partnerLevelList',
                                'url' => 'Distribution/partnerLevelList',
                                'is_menu' => 1,
                                'is_dev' => 0,
                                'sort' => 3,
                                'desc' => '股东等级',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ],
                            [
                                'module_name' => '人员管理',
                                'controller' => 'Distribution',
                                'method' => 'partnerList',
                                'url' => 'Distribution/partnerList',
                                'is_menu' => 1,
                                'is_dev' => 0,
                                'sort' => 4,
                                'desc' => '人员管理',
                                'module_picture' => '',
                                'icon_class' => '',
                                'is_control_auth' => 1
                            ],
                    
                        ]
                    ],
                ]
            ],
            [
                'module_name' => '分销佣金',
                'controller' => 'Commission',
                'method' => 'userAccountList',
                'url' => 'Commission/userAccountList',
                'parent' => ['module' => 'admin', 'controller' => 'account',  'method' => 'shopaccount', 'level' => 1],
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 5,
                'desc' => '分销佣金',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1,
                'child' => [
                    [
                        'module_name' => '佣金明细',
                        'controller' => 'Commission',
                        'method' => 'userAccountRecordsDetail',
                        'url' => 'Commission/userAccountRecordsDetail',
                        'is_menu' => 1,
                        'is_dev' => 0,
                        'sort' => 5,
                        'desc' => '佣金明细',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1
                    ],
                    [
                        'module_name' => '账户详情',
                        'controller' => 'Commission',
                        'method' => 'promoterAccount',
                        'url' => 'Commission/promoterAccount',
                        'is_menu' => 1,
                        'is_dev' => 0,
                        'sort' => 2,
                        'desc' => '账户详情',
                        'module_picture' => '',
                        'icon_class' => '',
                        'is_control_auth' => 1
                    ]
                ]
            ],
            [
              'module_name' => '佣金计算',
              'controller' => 'Commission',
              'method' => 'commissionDistributionList',
              'url' => 'Commission/commissionDistributionList',
              'parent' => ['module' => 'admin', 'controller' => 'account',  'method' => 'shopaccount', 'level' => 1],
              'is_menu' => 1,
              'is_dev' => 0,
              'sort' => 6,
              'desc' => '佣金计算',
              'module_picture' => '',
              'icon_class' => '',
              'is_control_auth' => 1,
              'child' =>[
                  [
                      'module_name' => '三级分销',
                      'controller' => 'Commission',
                      'method' => 'commissionDistributionList',
                      'url' => 'Commission/commissionDistributionList',
                      
                      'is_menu' => 1,
                      'is_dev' => 0,
                      'sort' => 2,
                      'desc' => '三级分销',
                      'module_picture' => '',
                      'icon_class' => '',
                      'is_control_auth' => 1
                  ],
                  [
                      'module_name' => '区域分销',
                      'controller' => 'Commission',
                      'method' => 'commissionRegionAgentList',
                      'url' => 'Commission/commissionRegionAgentList',
                      'is_menu' => 1,
                      'is_dev' => 0,
                      'sort' => 2,
                      'desc' => '区域分销',
                      'module_picture' => '',
                      'icon_class' => '',
                      'is_control_auth' => 1
                  ],
                  [
                      'module_name' => '股东分红',
                      'controller' => 'Commission',
                      'method' => 'commissionPartnerList',
                      'url' => 'Commission/commissionPartnerList',
                      'is_menu' => 1,
                      'is_dev' => 0,
                      'sort' => 2,
                      'desc' => '股东分红',
                      'module_picture' => '',
                      'icon_class' => '',
                      'is_control_auth' => 1
                  ]
              ]
            ],
            [
                'module_name' => '佣金提现',
                'controller' => 'Commission',
                'method' => 'userCommissionWithdrawList',
                'url' => 'Commission/userCommissionWithdrawList',
                'parent' => ['module' => 'admin', 'controller' => 'account',  'method' => 'shopaccount', 'level' => 1],
                'is_menu' => 1,
                'is_dev' => 0,
                'sort' => 7,
                'desc' => '分销商佣金提现',
                'module_picture' => '',
                'icon_class' => '',
                'is_control_auth' => 1
            ]
        ];
        return $menu;

    }
}