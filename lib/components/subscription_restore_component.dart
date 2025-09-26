import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:nb_utils/nb_utils.dart';
import 'package:vizion_ai/generated/assets.dart';
import 'package:vizion_ai/main.dart';
import 'package:vizion_ai/services/in_app_purchase.dart';
import 'package:vizion_ai/utils/app_common.dart';
import 'package:vizion_ai/utils/colors.dart';
import 'package:vizion_ai/utils/common_base.dart';

class SubscriptionRestoreComponent extends StatelessWidget {
  const SubscriptionRestoreComponent({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: Get.width,
      padding: const EdgeInsets.symmetric(vertical: 32),
      decoration: boxDecorationDefault(color: context.cardColor),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            children: [
              Image.asset(
                Assets.assetsAppLogo,
                width: 30,
                height: 30,
              ),
              15.width,
              Text(locale.value.restorePurchase, style: primaryTextStyle()),
            ],
          ).paddingLeft(15),
          16.height,
          Text(locale.value.restorePurchaseMessage, textAlign: TextAlign.center, style: primaryTextStyle(color: secondaryTextColor)).paddingSymmetric(horizontal: 32),
          32.height,
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              AppButton(
                color: isDarkMode.value ? black : white,
                padding: const EdgeInsets.symmetric(vertical: 12),
                shapeBorder: RoundedRectangleBorder(side: BorderSide(color: isDarkMode.value ? appColorPrimary : context.primaryColor), borderRadius: BorderRadius.circular(10)),
                text: locale.value.cancel,
                textStyle: TextStyle(color: isDarkMode.value ? appColorPrimary : context.primaryColor),
                onTap: () {
                  Get.back();
                },
              ).expand(),
              32.width,
              AppButton(
                padding: const EdgeInsets.symmetric(vertical: 12),
                shapeBorder: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                text: locale.value.confirm,
                textStyle: appButtonTextStyleWhite,
                onTap: () {
                  InAppPurchaseService purchaseService = InAppPurchaseService();
                  purchaseService.restorePurchase();

                  Get.back();
                },
              ).expand(),
            ],
          ).paddingSymmetric(horizontal: 32),
        ],
      ),
    );
  }
}
