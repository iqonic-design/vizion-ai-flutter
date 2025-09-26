import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:nb_utils/nb_utils.dart';
import 'package:slide_action/slide_action.dart';
import '../../components/cached_image_widget.dart';
import '../../main.dart';
import 'walkthrough_controller.dart';
import '../../utils/colors.dart';

class WalkthroughScreen extends StatelessWidget {
  WalkthroughScreen({super.key});

  final WalkthroughController walkthroughController = Get.put(WalkthroughController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: canvasColor,
      body: Column(
        children: [
          SizedBox(height: Get.height * 0.1),
          CarouselSlider(
            options: CarouselOptions(
                height: Get.height * 0.52,
                viewportFraction: 0.72,
                autoPlay: false,
                enlargeCenterPage: true,
                // enableInfiniteScroll: false,
                enlargeFactor: 0.25,
                onPageChanged: (index, reason) {
                  walkthroughController.currentPage(index);
                }),
            items: walkthroughController.walkthroughDetails.map((i) {
              return Builder(
                builder: (BuildContext context) {
                  return ClipRRect(
                    borderRadius: radius(),
                    child: CachedImageWidget(
                      url: i.image.validate(),
                      fit: BoxFit.fill,
                    ),
                  );
                },
              );
            }).toList(),
          ),
          SizedBox(height: Get.height * 0.05),
          Obx(
            () => Center(
              child: Text(
                walkthroughController.walkthroughDetails[walkthroughController.currentPage.value].title ?? "",
                textAlign: TextAlign.center,
                style: secondaryTextStyle(color: bodyDark, size: 34),
              ).paddingSymmetric(horizontal: 32),
            ),
          ),
          const Spacer(),
          SlideAction(trackBuilder: (context, state) {
            return Container(
              decoration: BoxDecoration(
                color: appColorSecondary,
                borderRadius: BorderRadius.circular(30),
              ),
              child: Center(
                child: Text(
                  locale.value.slideToSkip,
                  textAlign: TextAlign.center,
                  style: boldTextStyle(
                    weight: FontWeight.w400,
                    color: black,
                    size: 16,
                  ),
                ),
              ),
            );
          }, thumbBuilder: (context, state) {
            return Container(
              decoration: BoxDecoration(
                color: Colors.black,
                borderRadius: BorderRadius.circular(30),
              ),
              child: const Icon(Icons.arrow_forward_ios, color: appColorSecondary, size: 24),
            );
          }, action: () {
            walkthroughController.handleSkip();

            return Future(() => null);
          }).paddingOnly(left: 20, right: 20, bottom: 40),
        ],
      ),
    );
  }
}
