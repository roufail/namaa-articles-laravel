<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Models\Admin\Article;
use App\Models\Admin\Comment;

use App\Models\User;
use \DB;
class ArticleTest extends TestCase
{

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_get_homepage() {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_get_all_approved_articles(): void
    {

        $articlesCount = Article::Approved()->with('user:name,id')->select('id','title','created_at','excerpt','user_id')->count();
        $this->assertTrue(true);
        $this->assertGreaterThan(  
            0,  
            $articlesCount,  
            "actual value is not greater than expected"
        );  
    }


    public function test_create_article(): void
    {
        $article = Article::create([
            'title'     => 'test article created',
            'content'   => fake()->paragraph(5),
            'excerpt'   => fake()->paragraph(1),
            'meta_data' => implode(",", fake()->randomElements(['news', 'arabic', 'english'], 2)),
            'approved'  => random_int(0, 1),
            'user_id'   => \App\Models\User::all()->random(1)->first()->id,
        ]);
        $this->assertEquals( 
            'test article created', 
            $article->title, 
            "actual value is not equals to expected"
        ); 
    }


    public function test_get_random_article(): void
    {
        $articleCount = Article::all()->random(1)->count();
        $this->assertEquals( 
            1, 
            $articleCount, 
            "actual value is not equals to expected"
        ); 
    }


    public function test_delete_random_article(): void
    {

        $article   = Article::inRandomOrder()->limit(1)->first();
        $comments  = Comment::where('article_id', $article->id )->delete();
        $article_deleted = $article->delete();
        $this->assertEquals( 
            true, 
            $article_deleted, 
            "actual value is not equals to expected"
        ); 
    }

    
}
