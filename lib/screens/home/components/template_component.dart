import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:nb_utils/nb_utils.dart';
import 'package:vizion_ai/generated/assets.dart';
import 'package:vizion_ai/main.dart';
import 'package:vizion_ai/screens/favourite/fav_controller.dart';
import 'package:vizion_ai/screens/favourite/models/favourite_res_model.dart';
import 'package:vizion_ai/screens/favourite/services/favourite_services_api.dart';
import 'package:vizion_ai/utils/colors.dart';
import 'package:vizion_ai/utils/common_base.dart';
import '../../../utils/app_common.dart';
import '../model/home_detail_res.dart';

class TemplateComponent extends StatelessWidget {
  final void Function()? onTapCard;
  final RxBool isLoading;
  final Rx<CustomTemplate> customTemplate;

  TemplateComponent({super.key, required this.onTapCard, required this.isLoading, required this.customTemplate});

  final RxBool isFavClicked = false.obs;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTapCard,
      child: SizedBox(
        width: 160,
        height: 200,
        child: Card(
          color: context.cardColor,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Padding(
            padding: const EdgeInsets.all(12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Assets.iconsIcAiPhotoEnhancer.iconImage(size: 22),
                    IconButton(
                      onPressed: () {
                        doIfLoggedIn(() async {
                          if (isFavClicked.value) return;
                          isFavClicked(true);

                          if (customTemplate.value.inWishList.value) {
                            // Removing from favourites
                            FavController favController = Get.find();
                            favController.favourites.removeWhere(
                              (element) => element.templateData.id == customTemplate.value.id,
                            );

                            toast(
                              locale.value.removedFromFavorites,
                              length: Toast.LENGTH_SHORT,
                              gravity: ToastGravity.BOTTOM,
                            );
                          } else {
                            // Adding to favourites
                            toast(
                              locale.value.addedToFavorites,
                              length: Toast.LENGTH_SHORT,
                              gravity: ToastGravity.BOTTOM,
                            );
                          }

                          await FavouriteServices.onTapFavourite(
                            favData: FavData(templateData: customTemplate.value),
                          );

                          isFavClicked(false);
                        });
                      },
                      icon: Obx(
                        () => Icon(
                          customTemplate.value.inWishList.value ? Icons.star : Icons.star_border_outlined,
                          color: isDarkMode.value ? appColorSecondary : appColorPrimary,
                          size: 20,
                        ),
                      ),
                    ),
                  ],
                ),
                8.height,
                Text(
                  customTemplate.value.templateName,
                  style: primaryTextStyle(),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
                8.height,
                Text(customTemplate.value.description, style: secondaryTextStyle(), maxLines: 3, overflow: TextOverflow.ellipsis).expand(),
              ],
            ),
          ),
        ),
      ),
    );
  }
}