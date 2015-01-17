<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Form\Form;
use Mendo\Form\FieldSet;
use Mendo\Form\Element;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class FormTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $addressFieldSet = new FieldSet('address');
        $address = $addressFieldSet->setEntity('Address');

        $addressFieldSet->add((new Element\Text('street'))
            ->setLabel('Street')
            ->setAttribute('placeholder', 'Enter street')
            ->setFilters('required|trim'));
        $addressFieldSet->add((new Element\Text('city'))
            ->setLabel('City')
            ->setAttribute('placeholder', 'Enter city')
            ->setFilters('required|trim'));

        $userFieldSet = new FieldSet('user');
        $user = $userFieldSet->setEntity('User');
        $user->setAddress($address);

        $userFieldSet->add((new Element\Text('firstName'))
            ->setLabel('First name')
            ->setAttribute('placeholder', 'Enter first name')
            ->setFilters('required|trim'));
        $userFieldSet->add((new Element\Text('lastName'))
            ->setLabel('Last name')
            ->setAttribute('placeholder', 'Enter last name')
            ->setFilters('required|trim'));
        $userFieldSet->add($addressFieldSet);

        $form = new Form();
        $form->add($userFieldSet);
        $this->form = $form;
    }

    public function testForm()
    {
        $html = (string) $this->form->getComponent('user')->getComponent('firstName');
        $expectedHtml = '<input name="user[firstName]" value="" type="text" placeholder="Enter first name">' . "\n";
        $this->assertSame($expectedHtml, $html);

        $html = (string) $this->form->getComponent('user')->getComponent('address')->getComponent('street');
        $expectedHtml = '<input name="user[address][street]" value="" type="text" placeholder="Enter street">' . "\n";
        $this->assertSame($expectedHtml, $html);

        $data = [
            'user' => [
                'firstName' => 'Mathieu',
                'lastName' => 'Decaffmeyer',
                'address' => [
                    'street' => 'Foobar Street 42',
                    'city' => 'Foobar City',
                ],
            ],
        ];

        $this->form->setData($data);

        $html = (string) $this->form->getComponent('user')->getComponent('firstName');
        $expectedHtml = '<input name="user[firstName]" value="Mathieu" type="text" placeholder="Enter first name">' . "\n";
        $this->assertSame($expectedHtml, $html);

        $html = (string) $this->form->getComponent('user')->getComponent('address')->getComponent('street');
        $expectedHtml = '<input name="user[address][street]" value="Foobar Street 42" type="text" placeholder="Enter street">' . "\n";
        $this->assertSame($expectedHtml, $html);
    }
}

class User
{
    private $firstName;
    private $lastName;
    private $address;
    private $articles = []; // todo collection of fieldsets

    public function __construct($firstName, $lastName, Address $address)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        return $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        return $this->lastName = $lastName;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        return $this->address = $address;
    }

    public function addArticle(Article $article)
    {
        $this->articles[$article->getId()] = $article;
    }

    public function removeArticle($articleId)
    {
        unset($this->articles[$articleId]);
    }

    public function getArticle($articleId)
    {
         return $this->articles[$articleId];
    }

    public function getArticles()
    {
        return $this->articles;
    }
}

class Address
{
    private $street;
    private $city;

    public function __construct($street, $city)
    {
        $this->street = $street;
        $this->city = $city;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }
}

class Article
{
    private $id;
    private $label;
    private $price;

    public function __construct($id, $label, $price)
    {
        $this->id = $id;
        $this->label = $label;
        $this->price = $price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}
