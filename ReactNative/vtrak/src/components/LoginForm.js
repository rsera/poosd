import React, { Component } from 'react';
import { Text, View, StyleSheet, TouchableOpacity } from 'react-native';

import Button from './common/Button';
import Card from './common/Card';
import CardSection from './common/CardSection';
import Input from './common/Input';
import { Actions } from 'react-native-router-flux';
import Header from './header';


class LoginForm extends Component {
  state = { username: '', password: '' };

  render() {
    return (
      <View>
        <Header headerText={'vTrak'} />

        <Card>
          <CardSection>
            <Input
              label="Username"
              value={this.state.username}
              onChangeText={username => this.setState({ username })}
            />
          </CardSection>

          <CardSection>
            <Input
              secureTextEntry
              label="Password"
              value={this.state.password}
              onChangeText={password => this.setState({ password })}
            />
          </CardSection>

        </Card>

        <View style={styles.buttonContainerStyle}>

          <Button onPress={() => Actions.homescreen()} >
            Log In
          </Button>

          <TouchableOpacity>
            <Text style={styles.textStyle} onPress={() => Actions.signup()} >
              New to vTrak?
                <Text style={{fontWeight:'bold', color: '#76CB89'}}> Sign Up!</Text>
            </Text>
          </TouchableOpacity>

        </View>

      </View>

    );
  }
}

const styles = StyleSheet.create({
  buttonContainerStyle: {
    height: 70,
    marginTop: 5,
    marginBottom: 5,
  },
  textStyle: {
    paddingTop: 10,
    alignSelf: 'center',
    fontSize: 14
  }
});

export default LoginForm;
