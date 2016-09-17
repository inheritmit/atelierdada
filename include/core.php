<?php
	/** Core configuration file
	 * ================================================================================
	 *	@author string Mitesh Tandel
	 *  @date date 21 March, 2016
	 *  @filename string core.php
	 * ================================================================================
	 * All core configurations have been provided here to update the system
	 */

	/** Login criteria of the system
	 * @param string username: System login is username based
     *                       - Username field should be provided in account registration
	 *                       - Forgot password link is optional (Check 'VERIFY' variable)
	 *                       - if email address is available, password will be sent to email address,
     *                       otherwise fails
     * @param string email: System login is email based
     *                    - Forgot password link is provided
     *                    - Email field in account would be unique
	 */
	define('LOGIN', 'email');

    /** Enable/Disable account verification by email before first use
     *
     * @param bool true: Verify the account before first use
     *                 Email would be sent to registered account
     *                 User must click on the link to verify
     * @param bool false: Do not verify account before first use
     *                  Administrator provides fill password during the account creation
     *                  Administrator informs account holder with password details
     */
    define('VERIFY', 'false');