<?php
    namespace SciMS\DAO;
    
    use \Symfony\Component\Yaml\Yaml;
    use \SciMS\Domain\Website;

    /**
     * Class WebsiteDAO.
     *
     * Return the website setting.
     *
     * @author Kero76
     * @package SciMS\DAO
     * @since SciMS 0.3
     * @version 1.0
     */
    class WebsiteDAO extends DAO {
    
        /**
         * Return an instance of Website who representing the website settings.
         *
         * @param string $path_setting_file
         *  The path of the setting file in Yaml.
         * @return \SciMS\Domain\Website
         * @since SciMS 0.3
         * @version 1.0
         */
        public function findSettings($path_setting_file) {
            return $this->buildDomain(Yaml::parse(file_get_contents($path_setting_file))['website']);
        }
    
        /**
         * Method use for build a Domain object.
         *
         * @access  protected.
         *
         * @param array $row
         *  The data use for build Domain.
         *
         * @return mixed
         *  The corresponding instance of Domain object.
         * @since   SciMS 0.1
         * @version 1.0
         */
        protected function buildDomain(array $row) {
            return new Website($row);
        }
    }