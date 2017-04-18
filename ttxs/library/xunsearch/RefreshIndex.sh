#!/bin/sh
# check model
if [ $1 = 'model' ]; then
    PRO='model'
    SQL='SELECT view_id,user_id,name,py_name,pre_py_name,is_original,collection_count,like_count,download_count,comment_count,view_count,print_count,has_print_params,category_first,category_second,category_third,origin,is_open,upload_stamp FROM model WHERE status = 1 AND is_open =1'
elif [ $1 = 'album' ]; then
    PRO='album'
    SQL='SELECT album_id,user_id,name,py_name,pre_py_name,focus_count,view_count,is_open,add_stamp,model_view_count FROM album WHERE status = 1 AND is_open =1'
elif [ $1 = 'print' ]; then
    PRO='print'
    SQL='SELECT print_id,view_id,view_name,py_name,pre_py_name,view_count,stamp FROM print_result WHERE status = 1'
elif [ $1 = 'user' ]; then
    PRO='user'
    SQL='SELECT user_id,nickname,py_name,pre_py_name,album_count,print_result_count,model_view_count,be_cared_count,register_stamp,is_designer,is_old_user FROM user WHERE status = 1 AND (is_designer = 1 OR is_old_user = 1)'
elif [ $1 = 'search' ]; then
    PRO='search'
    SQL='SELECT id,file_id,name,py_name,pre_py_name,type FROM search'
elif [ $1 = 'seekmodel' ]; then
    PRO='seekmodel'
    SQL='SELECT sm_id,title,py_title,pre_py_title,reward_egg,has_answer,comment_count,adopt_stamp,add_stamp FROM seek_model where status != -9'
else
    echo 'project not exists!'
fi
# do rebuild index
FILEPATH=$(cd "$(dirname "$0")"; pwd)
"$FILEPATH"/sdk/php/util/Indexer.php --rebuild --source=mysql://xunsearch:163db0e5934f20@localhost/dayinji --sql="$SQL" --project="$PRO"
