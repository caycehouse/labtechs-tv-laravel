import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';

const styles = {
  grow: {
    flexGrow: 1,
  },
  inline: {
    display: 'inline',
  },
};

const Header = props => {
  const { classes } = props;
  return (
    <AppBar position="static" color="primary">
      <Toolbar>
        <Typography variant="h6" color="secondary" className={classes.grow}>
          Labtechs TV
        </Typography>
        <Typography variant="h6" color="inherit" className={classes.inline}>
          Crafted by
          <a
            href="https://caycehouse.com"
            target="_blank"
            rel="noopener noreferrer"
          >
            <Typography
              variant="h6"
              color="secondary"
              className={classes.inline}
            >
              &nbsp;Cayce House
            </Typography>
          </a>
        </Typography>
      </Toolbar>
    </AppBar>
  );
};

Header.propTypes = {
  classes: PropTypes.shape({
    grow: PropTypes.string.isRequired,
    inline: PropTypes.string.isRequired,
  }).isRequired,
};

export default withStyles(styles)(Header);