<?php
//TODO: finish View
$class = Pimcore\Model\Object\ClassDefinition::getByName("CoreShopUser");

$postValue = function ($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }

    return null;
};
?>

<div id="main-container" class="container">
    <!-- Breadcrumb Starts -->
    <ol class="breadcrumb">
        <li><a href="<?=\CoreShop::getTools()->url(array("lang" => $this->language), "coreshop_index", true)?>"><?=$this->translate("Home")?></a></li>
        <li class="active"><a href="<?=\CoreShop::getTools()->url(array("lang" => $this->language, "act" => "register"), "coreshop_checkout")?>"><?=$this->translate("Register")?></a></li>
    </ol>

    <?=$this->partial("coreshop/helper/order-steps.php", array("step" => 2));?>

    <!-- Breadcrumb Ends -->
    <!-- Main Heading Starts -->
    <h2 class="main-heading text-center">
        <?=$this->translate("Register")?> <br />
        <span><?=$this->translate("Create New Account")?></span>
    </h2>
    <!-- Main Heading Ends -->
    <!-- Registration Section Starts -->
    <section class="registration-area">
        <?php if($this->error) { ?>
            <div class="alert alert-danger">
                <?=$this->error?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-sm-12">
                <!-- Registration Block Starts -->
                <div class="panel panel-smart">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=$this->translate("Personal Information")?></h3>
                    </div>
                    <div class="panel-body">
                        <!-- Registration Form Starts -->
                        <form class="form-horizontal" role="form" id="shop-register-form" action="<?=\CoreShop::getTools()->url(array("lang" => $this->language, "act" => "register"), "coreshop_user")?>" method="post">

                            <input type="hidden" name="browserName" id="browserName" />
                            <input type="hidden" name="majorVersion" id="majorVersion" />
                            <input type="hidden" name="fullVersion" id="fullVersion" />
                            <input type="hidden" name="appName" id="appName" />
                            <input type="hidden" name="userAgent" id="userAgent" />
                            <input type="hidden" name="os" id="os" />
                            <?php if($this->redirect) { ?>
                            <input type="hidden" name="_redirect" value="<?=$this->redirect?>" />
                            <?php }?>

                            <!-- Personal Information Starts -->
                            <div class="form-group">
                                <label for="firstname" class="col-sm-3 control-label"><?=$this->translate("First Name")?> :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?=$this->translate("First Name")?>">
                                </div>
                                <div data-for="firstname" class="col-sm-push-3 col-sm-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="col-sm-3 control-label"><?=$this->translate("Last Name")?> :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?=$this->translate("Last Name")?>">
                                </div>
                                <div data-for="lastname" class="col-sm-push-3 col-sm-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label"><?=$this->translate("Email")?> :</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?=$this->translate("Email")?>">
                                </div>
                                <div data-for="email" class="col-sm-push-3 col-sm-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="reemail" class="col-sm-3 control-label"><?=$this->translate("Re-Email")?> :</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="reemail" name="reemail" placeholder="<?=$this->translate("Re-Email")?>">
                                </div>
                                <div data-for="reemail" class="col-sm-push-3 col-sm-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label"><?=$this->translate("Password")?> :</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="<?=$this->translate("Password")?>">
                                </div>
                                <div data-for="password" class="col-sm-push-3 col-sm-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputRePassword" class="col-sm-3 control-label"><?=$this->translate("Re-Password")?> :</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="repassword" name="repassword" placeholder="<?=$this->translate("Re-Password")?>">
                                </div>
                                <div data-for="repassword" class="col-sm-push-3 col-sm-9"></div>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="col-sm-3 control-label"><?=$this->translate("Gender")?></label>
                                <div class="col-sm-9">
                                    <select name="gender" class="form-control" title="<?=$this->translate("Geschlecht")?>">
                                        <option></option>
                                        <?php
                                        $fd = $class->getFieldDefinition("gender");
                                        $options = $fd->getOptions();
                                        $value = $postValue("gender");
                                        ?>
                                        <?php foreach ($options as $option) { ?>
                                            <?php if ($option['key']) { ?>
                                                <option value="<?=$option['value']?>" <?=$value == $option['value'] ? "selected" : ""?>><?=$this->translate($option['key'])?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div data-for="gender" class="col-sm-push-3 col-sm-9"></div>
                            </div>

                            <h3 class="panel-heading inner">
                                <?=$this->translate("Address")?>
                            </h3>

                            <?=$this->template("coreshop/user/helper/address.php") ?>
                            <h3 class="panel-heading inner">
                                <?=$this->translate("Newsletter")?>
                            </h3>

                            <div class="form-group">
                                <span class="col-sm-3 control-label"><?=$this->translate("Newsletter")?> :</span>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="newsletterActive" id="newsletterActiveYes" value="1" checked>
                                            <?=$this->translate("Subscribe")?>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="newsletterActive" id="newsletterActiveNo" value="0">
                                            <?=$this->translate("Unsubscribe")?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> <?=$this->translate("I'v read and agreed on ")?> <a id="openTerms" data-toggle="modal" data-target="#termsAndConditions"><?=$this->translate("Terms & Conditions")?></a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-black">
                                        <?=$this->translate("Register")?>
                                    </button>
                                </div>
                            </div>
                            <!-- Password Area Ends -->
                        </form>
                        <!-- Registration Form Starts -->
                    </div>
                </div>
                <!-- Registration Block Ends -->
            </div>
        </div>
    </section>
    <!-- Registration Section Ends -->
</div>
<!-- Main Container Ends -->


<div class="modal fade" id="termsAndConditions" tabindex="-1" role="dialog" aria-labelledby="termsAndConditionLabel">
    <div class="modal-dialog" role="document" style="z-index:1040;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="termsAndConditionLabel"><?=$this->translate("Terms and Conditions")?></h4>
            </div>
            <div class="modal-body">
                <?=$this->inc("/" . $this->language . "/shop/snippet/terms")?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php

//Create Javascript rules for client-side validation
$mandatoryFields = \CoreShop\Model\User::getMandatoryFields();
$addressMandatoryFields = \CoreShop\Model\User\Address::getMandatoryFields();

$bootstrapValidator = [
    'email' => [
        'container' => '[data-for=email]',
        'validators' => [
            'notEmpty' => [
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Email is required')
            ],
            'emailAddress' => [
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Email is invalid')
            ],
            'identical' => [
                'field' => 'reemail',
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Email hast to be equal')
            ]
        ]
    ],
    'reemail' => [
        'container' => '[data-for=reemail]',
        'validators' => [
            'notEmpty' => [
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Email is required')
            ],
            'emailAddress' => [
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Email is invalid')
            ],
            'identical' => [
                'field' => 'email',
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Email hast to be equal')
            ]
        ]
    ],
    'password' => [
        'container' => '[data-for=password]',
        'validators' => [
            'notEmpty' => [
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Password is required')
            ],
            'different' => [
                'field' => 'username',
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Password and Username must be different')
            ],
            'stringLength' => [
                'min' => 8,
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Password must be at least 8 characters')
            ],
            'identical' => [
                'field' => 'repassword',
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Passwords has to be equal')
            ]
        ]
    ],
    'repassword' => [
        'container' => '[data-for=repassword]',
        'validators' => [
            'notEmpty' => [
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Password is required')
            ],
            'different' => [
                'field' => 'username',
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Password and Username must be different')
            ],
            'stringLength' => [
                'min' => 8,
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Password must be at least 8 characters')
            ],
            'identical' => [
                'field' => 'password',
                'message' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . $this->translate('Passwords has to be equal')
            ]
        ]
    ]
];
foreach($mandatoryFields as $field) {
    if(!array_key_exists($field->getName(), $bootstrapValidator)) {
        $bootstrapValidator[$field->getName()] = [
            'container' => '[data-for='.$field->getName().']',
            'validators' => [
                'notEmpty' => [
                    'message' => '<i class="glyphicon glyphicon-remove-circle"></i> '.sprintf($this->translate("%s is required"), $field->getTitle())
                ]
            ]
        ];
    }
}

foreach($addressMandatoryFields as $field) {
    if(!array_key_exists('address_' . $field->getName(), $bootstrapValidator)) {
        $bootstrapValidator['address_' . $field->getName()] = [
            'container' => '[data-for=address_'.$field->getName().']',
            'validators' => [
                'notEmpty' => [
                    'message' => '<i class="glyphicon glyphicon-remove-circle"></i> '.sprintf($this->translate("%s is required"), $field->getTitle())
                ]
            ]
        ];
    }
}


?>

<script type="text/javascript">
    var fieldsToValidate = <?=\Zend_Json::encode($bootstrapValidator)?>;
</script>

