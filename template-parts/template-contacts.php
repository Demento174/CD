<?php
/*
Template Name: Контакты
*/
get_header();
renderBlock('pages/contacts/contacts',['common'],'options');
renderBlock('pages/contacts/question',[
    'title'=>get_field('question')['title'],
    'description'=>get_field('question')['description']
]);
get_footer();