<?php

/*
 * The template for displaying customer active questiona dashboard widget
 * Override this template by copying it to yourtheme/dc-product-vendor/vendor-dashboard/dashboard-widgets/wcmp_vendor_products_cust_qna.php
 *
 * @author 	WC Marketplace
 * @package 	WCMp/Templates
 * @version   3.0.0
 */
if (!defined('ABSPATH')) {
    // Exit if accessed directly
    exit;
}
global $WCMp;

do_action('before_wcmp_vendor_dashboard_products_cust_qna');
?>
<div class="customer-questions-panel dash-widget-dt">
    <table id="customer_questions" class="wcmp-widget-dt table" width="100%">
        <thead>
            <tr><th></th></tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
jQuery(document).ready(function($) {
    var customer_questions;
    customer_questions = $('#customer_questions').DataTable({
        ordering  : false,
        lengthChange : false,
        pageLength : 5,
        info:     false,
        searching  : false,
        processing: false,
        serverSide: true,
        pagingType: 'numbers',
        language: {
            emptyTable: '<article class="reply-item" style="border-bottom:none;"><div class="col-md-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;"><?php echo __('No customer query found.', 'dc-woocommerce-multi-vendor') ?></div></article>',
        },
        preDrawCallback: function( settings ) {
            $('#customer_questions thead').hide();
            $('.dataTables_paginate').parent().removeClass('col-sm-7').addClass('col-sm-12').siblings('div').hide();
            var info = this.api().page.info();
            if (info.recordsTotal <= 5) {
                $('.dataTables_paginate').parent().parent().hide();
            }else{
                $('.dataTables_paginate').parent().parent().show();
            }
        },
        ajax:{
            url : woocommerce_params.ajax_url+'?action=wcmp_vendor_dashboard_customer_questions_data', 
            type: "post",
            'error': function(xhr, status, error) {
                $("#customer_questions tbody").append('<tr class="odd"><td valign="top" colspan="1" class="dataTables_empty"><article class="reply-item" style="border-bottom:none;"><div class="col-md-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">'+error+' - <a href="javascript:window.location.reload();"><?php _e('Reload', 'dc-woocommerce-multi-vendor'); ?></a></div></article></td></tr>');
                $("#customer_questions_processing").css("display","none");
            }
        }
    });
});
</script>
<?php
do_action('after_wcmp_vendor_dashboard_products_cust_qna');
