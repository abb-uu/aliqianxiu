
    // ============================ categories
    function delete_pub_del(checkboxs, checkboxAll, allDelect, boo) {
        // 获取tbody内所有多选框
        var $checkboxs = checkboxs;
        // 获取thead的多选框
        var $checkboxAll = checkboxAll;
        // 获取批量删除按钮
        var $allDelect = allDelect;
        // 定义一个数组用于存储每个选中的checkbox的data-id
        var arrDataId = [];

        var arrDataId_aud = [];
        // 当checkbox状态改变时触发
        $checkboxs.on('change', function () {
            var ratify = $(this).parent().parent().children().eq(5).text();
            if ($(this).prop('checked')) {
                // 如果当前checkbox为选中状态时将data-id的值添加到数组中
                arrDataId.push($(this).data('id'));
                if(ratify == "待审核") {
                    arrDataId_aud.push($(this).data('id'));
                }
            } else {
                // 否则从数组中删除当前checkbox的data-id的值
                var index_id = arrDataId.indexOf($(this).data('id'));
                arrDataId.splice(index_id, 1);
                if(ratify == "待审核") {
                    arrDataId_aud.splice(index_id, 1);
                }
            }
            // 根据数组的长度是否为0来判断批量删除按钮的显示与隐藏
            arrDataId.length ? $allDelect.fadeIn() : $allDelect.fadeOut();
            $checkboxAll.prop('checked', arrDataId.length == $checkboxs.length);
            // 设置发送请求时传入的数据
            if(boo) {
                $allDelect.get(0).dataset.id = arrDataId;
            }else {
                $allDelect.children().get(1).dataset.id = arrDataId;
                
                
                $allDelect.children().get(0).dataset.id = arrDataId_aud;
            }
        })
        
        // 全选操作
        $checkboxAll.on('change', function () {
            // 如果没有数据则不执行操作
            if(!$checkboxs.length) return;
            // tbody内所有多选框状态与全选按钮状态一致
            $checkboxs.prop('checked', $(this).prop('checked'));
            if ($(this).prop('checked') && $checkboxs.length) {
                // 如果当前checkbox为选中状态时将所有data-id的值添加到数组中
                arrDataId = [];
                $checkboxs.each(function (index, ele) {
                    arrDataId.push($(ele).data('id'));
                    if($(this).parent().parent().children().eq(5).text() == "待审核") {
                        arrDataId_aud.push($(this).data('id'));
                    }
                })
            } else {
                // 否则从数组中删除所有checkbox的data-id的值
                arrDataId = [];
                arrDataId_aud = [];
            }
            // 根据数组的长度是否为0来判断批量删除按钮的显示与隐藏
            arrDataId.length ? $allDelect.fadeIn() : $allDelect.fadeOut();
            $checkboxAll.prop('checked', arrDataId.length == $checkboxs.length);
            // 设置发送请求时传入的数据
            if(boo) {
                $allDelect.get(0).dataset.id = arrDataId;
            }else {
                $allDelect.children().get(1).dataset.id = arrDataId;


                $allDelect.children().get(0).dataset.id = arrDataId_aud;
            }
        })
        
    }



    // function delete_pub_app(checkboxs, checkboxAll, allDelect) {
    //     // 获取tbody内所有多选框
    //     var $checkboxs = checkboxs;
    //     // 获取thead的多选框
    //     var $checkboxAll = checkboxAll;
    //     // 获取批量批准按钮
    //     var $allDelect = allDelect;
    //     // 定义一个数组用于存储每个选中的checkbox的data-id
    //     var arrDataId = [];
    //     // 当checkbox状态改变时触发
    //     $checkboxs.on('change', function () {
    //         if ($(this).prop('checked')) {
    //             // 如果当前checkbox为选中状态时将data-id的值添加到数组中
    //             arrDataId.push($(this).data('id'));
    //         } else {
    //             // 否则从数组中删除当前checkbox的data-id的值
    //             var index_id = arrDataId.indexOf($(this).data('id'))
    //             arrDataId.splice(index_id, 1);
    //         }
    //         // 根据数组的长度是否为0来判断批量删除按钮的显示与隐藏
    //         // arrDataId.length ? $allDelect.fadeIn() : $allDelect.fadeOut();
    //         // $checkboxAll.prop('checked', arrDataId.length == $checkboxs.length);
    //         // 设置发送请求时传入的数据
    //         $allDelect.prop('search', '?id=' + arrDataId);
    //     })
    
    //     // 全选操作
    //     $checkboxAll.on('change', function () {
    //         // 如果没有数据则不执行操作
    //         if(!$checkboxs.length) return;
    //         // tbody内所有多选框状态与全选按钮状态一致
    //         $checkboxs.prop('checked', $(this).prop('checked'));
    //         if ($(this).prop('checked') && $checkboxs.length) {
    //             // 如果当前checkbox为选中状态时将所有data-id的值添加到数组中
    //             $checkboxs.each(function (index, ele) {
    //                 arrDataId.push($(ele).data('id'));
    //             })
    //         } else {
    //             // 否则从数组中删除所有checkbox的data-id的值
    //             arrDataId = [];
    //         }
    //         // 根据数组的长度是否为0来判断批量删除按钮的显示与隐藏
    //         arrDataId.length ? $allDelect.fadeIn() : $allDelect.fadeOut();
    //         $checkboxAll.prop('checked', arrDataId.length == $checkboxs.length);
    //         // 设置发送请求时传入的数据
    //         if(boo) {
    //             $allDelect.prop('search', '?id=' + arrDataId);
    //         }else {
    //             $allDelect.children().eq(1).prop('search', '?id=' + arrDataId);
    //         }
    //     })
        
    // }


     