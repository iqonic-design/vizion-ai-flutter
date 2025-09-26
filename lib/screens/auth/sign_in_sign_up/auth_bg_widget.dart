import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:nb_utils/nb_utils.dart';
import 'package:vizion_ai/generated/assets.dart';
import 'package:vizion_ai/utils/app_common.dart';

class AuthBackground extends StatelessWidget {
  const AuthBackground({super.key});

  @override
  Widget build(BuildContext context) {
    return Align(
      alignment: Alignment.topLeft,
      widthFactor: Get.width,
      heightFactor: Get.height,
      child: Image.asset(
        isDarkMode.value ? Assets.imagesAuthBackgroundDark : Assets.imagesAuthBackground,
        errorBuilder: (context, error, stackTrace) => const SizedBox(),
      ),
    ).paddingRight(20);
  }
}
