<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */
 
/**
 * Doctrine_Template_Listener_Userid
 *
 * @package     Doctrine
 * @subpackage  Template
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 * @author      Thomas Boerger <tb@mosez.net>
 */
class Doctrine_Template_Listener_Userid extends Doctrine_Record_Listener
{
    /**
     * Array of userid options
     *
     * @var string
     */
    protected $_options = array();
 
    /**
     * __construct
     *
     * @param string $options.
     * @return void
     */
    public function __construct(array $options)
    {
        $this->_options = $options;
    }
 
    /**
     * preInsert
     *
     * @param object $Doctrine_Event.
     * @return void
     */
    public function preInsert(Doctrine_Event $event)
    {
        if(!$this->_options['created']['disabled']) {
            $createdName = $this->_options['created']['name'];
            $event->getInvoker()->$createdName = $this->getUserId('created');
        }
 
        if(!$this->_options['updated']['disabled'] && $this->_options['updated']['onInsert']) {
            $updatedName = $this->_options['updated']['name'];
            $event->getInvoker()->$updatedName = $this->getUserId('updated');
        }
    }
 
    /**
     * preUpdate
     *
     * @param object $Doctrine_Event.
     * @return void
     */
    public function preUpdate(Doctrine_Event $event)
    {
        if( ! $this->_options['updated']['disabled']) {
            $updatedName = $this->_options['updated']['name'];
            $event->getInvoker()->$updatedName = $this->getUserId('updated');
        }
    }
 
    /**
     * getUserId
     *
     * Gets the userid or username depending on field format
     *
     * @param string $type.
     * @return void
     */
    public function getUserId($type)
    {
        $options = $this->_options[$type];
 
        if ($options['expression'] !== false && is_string($options['expression'])) {
            return new Doctrine_Expression($options['expression']);
        } elseif ( sfContext::hasInstance() && !class_exists("pakeApp")) {
            switch($options['type']) 
            {
                case 'integer':
                    if (class_exists('sfGuardUser')) {
                      return sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
                    } else {
                      return sfContext::getInstance()->getUser()->getId();
                    }
                    break;
                case 'string':
                    return sfContext::getInstance()->getUser()->getUsername();
                    break;
                default:
                    return 'n/a';
                    break;
            }
        }
    }
}
