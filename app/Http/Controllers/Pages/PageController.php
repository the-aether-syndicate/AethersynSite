<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 8:12 PM
 */

namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Auth\RoleController;
use App\Models\Auth\Role;
use App\Models\Page\Page;
use App\Validation\PageValidation;

class PageController extends Controller
{
    public function getIndex()
    {
        return view('pages.pageindex');
    }

    public function getJoin()
    {
        if(auth()->user()==null||!auth()->user()->hasRole('Manager'))
        {
            return view('no');
        }
        return view('pages.join');
    }
    public function getPage($pageid)
    {
        $page = Page::find($pageid);
        $ptitle = $page->title;
        $id = $pageid;
        $pagecontent = $page->pagecontent;
        $created = $page->created_at;
        return view('pages.modularpage', compact('ptitle','pagecontent','created', 'id'));
    }
    public function getUser()
    {
        if(!auth()->user()->hasRole('Manager'))
        {
            return view('no');
        }
        $roles = Role::all()->map(function ($role){
           return $role->name;
        });

        return view('pages.users', compact('roles'));
    }
    public function getRoles()
    {

        return view('pages.roles');
    }
    public function newPage()
    {
        return view('pages.newpage');
    }
    public function editPage($pageid)
    {
        $page = Page::find($pageid);
        $ptitle = $page->title;
        $pagecontent = $page->pagecontent;
        return view('pages.editpage', compact('ptitle', 'pagecontent'));
    }
    public function postPage(PageValidation $request)
    {
        $title = $request->ptitle;
        $content = $request->pagecontent;

        $page = Page::updateOrCreate(['title' => $title],[ 'pagecontent' => $content]);


        return redirect()->route('pages',['title'=>$page->id]);
    }

}
